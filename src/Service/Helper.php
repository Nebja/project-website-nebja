<?php

namespace App\Service;

use App\Entity\Home;
use App\Entity\Videos;
use App\Repository\HomeRepository;
use App\Repository\VideosRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;

class Helper
{
    private ManagerRegistry $doc;
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     * @param ManagerRegistry $doc
     */
    public function __construct(LoggerInterface $logger, ManagerRegistry $doc)
    {
        $this->logger = $logger;
        $this->doc = $doc;
    }

    /**
     * @param String $projectPath
     * @param VideosRepository $videosRepository
     * @return void
     */
    public function addNewMovieFiles (String $projectPath, VideosRepository $videosRepository): void
    {
        $videosArray = $this->addVideosToDB($videosRepository,$projectPath);
        $this->removeVideosFromDB($videosRepository, $videosArray);
    }
    /**
     * @param String $projectPath
     * @param HomeRepository $homeRepository
     * @return void
     */
    public function addNewHomeMovies (String $projectPath, HomeRepository $homeRepository): void
    {
        $videosArray = $this->addHomeVideosToDB($homeRepository,$projectPath);
        $this->removeVideosFromDB($homeRepository, $videosArray);
    }

    /**
     * @param VideosRepository $videosRepository
     * @param String $path
     * @return array
     */
    private function addVideosToDB(VideosRepository $videosRepository, String $path): array
    {
        $array = array();
        $finder = new Finder();
        for ($i=0;$i <=1;$i++) {
            $type = $i === 0 ? 'Movie' : 'Episode';
            $finder->files()->depth('=='.$i)->in($path . '/public/Videos');
            foreach ($finder->files()->name('*.mp4') as $file) {
                $fileNameWithExtension = $file->getRelativePathname();
                $filenameWithoutExtension = basename($file->getFilename(), '.' . $file->getExtension());
                $file_exists = $videosRepository->findBy(['file' => $fileNameWithExtension]);
                if (empty($file_exists)) {
                    $object = new Videos;
                    $object->setFile($fileNameWithExtension)
                        ->setName($filenameWithoutExtension)
                        ->setEntryAt(new DateTimeImmutable())
                        ->setImgPoster($this->matchDbFileToExistingFile($path . '/public/img/posters', $filenameWithoutExtension, 'jpg'))
                        ->setSubsFile($this->matchDbFileToExistingFile($path . '/public/subs', $filenameWithoutExtension, 'vtt'))
                        ->setVideoType($type);
                    $videosRepository->add($object, true);
                    $this->logger->info($fileNameWithExtension . ' was added as Entry in Database');
                } else {
                    $posterName = $file_exists[0]->getName();
                    $subsName = $file_exists[0]->getName();
                    $file_exists[0]->setImgPoster($this->matchDbFileToExistingFile($path . '/public/img/posters', $posterName, 'jpg'))
                        ->setSubsFile($this->matchDbFileToExistingFile($path . '/public/subs', $subsName, 'vtt'));
                    $this->doc->getManager()->persist($file_exists[0]);
                    $this->doc->getManager()->flush();
                }
                $array[] = $fileNameWithExtension;
            }
        }
        return $array;
    }

    /**
     * @param HomeRepository $homeRepository
     * @param String $path
     * @return array
     */
    private function addHomeVideosToDB(HomeRepository $homeRepository, String $path): array
    {
        return array('path' => $path);
/*        $array = array();
        $finder = new Finder();
            $finder->files()->depth('== 0')->in($path . '/public/Home');
            foreach ($finder->files()->name('*.mp4') as $file) {
                $fileNameWithExtension = $file->getRelativePathname();
                $filenameWithoutExtension = basename($file->getFilename(), '.' . $file->getExtension());
                $file_exists = $homeRepository->findBy(['fileName' => $fileNameWithExtension]);
                if (empty($file_exists)) {
                    $object = new Home();
                    $object->setFileName($fileNameWithExtension)
                        ->setName($filenameWithoutExtension)
                        ->setCreated(new DateTimeImmutable())
                        ->setComments('NONE')
                        ->setPermissions(array("ROLE_USER"));
                    $homeRepository->add($object, true);
                    $this->logger->info($fileNameWithExtension . ' was added as Entry in Database');
                }
                $array[] = $fileNameWithExtension;
            }
        return $array;*/
    }
    /**
     * @param EntityRepository $repository
     * @param array $videosArray
     * @return void
     */
    private function removeVideosFromDB(EntityRepository $repository, array $videosArray ): void
    {
        $dbFile = $repository->findAll();
        foreach ($dbFile as $dbVideo){
            if (!in_array($dbVideo->getFile(), $videosArray, true)){
                $repository->remove($dbFile, true);
                $this->logger->info($dbFile->getFile().' was deleted from Database');
            }
        }
    }

    /**
     * @param String $path
     * @param String $fileName
     * @param String $ext
     * @return string
     */
    private function
    matchDbFileToExistingFile(String $path, String $fileName, String $ext): string
    {
        $fullName = $fileName.'.'.$ext;
        $finder = new Finder();
        $array = array();
        $finder->files()->in($path);
        foreach ($finder->files()->name('*.'.$ext) as $file){
            $fileNameWithExtension = $file->getRelativePathname();
            $array[] = $fileNameWithExtension;
        }
        if (in_array($fullName, $array, true)){
            return $fullName;
        }
        $this->logger->info($fullName.' was not found , generic.'.$ext.' was given');
        return 'generic.'.$ext;
    }
}
