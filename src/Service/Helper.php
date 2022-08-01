<?php

namespace App\Service;

use App\Entity\Videos;
use App\Repository\VideosRepository;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @return void
     */
    public function addNewMovieFiles (String $projectPath): void
    {
        $videosArray = $this->addVideosToDB($this->doc->getRepository(Videos::class),$projectPath);
        $this->removeVideosFromDB($this->doc->getRepository(Videos::class), $videosArray);
    }

    /**
     * @param $path
     * @return array
     */
    public function getCarouselImages ($path): array
    {
        $array = array();
        $finder = new Finder();
        $finder->files()->in($path.'/public/img/carousel')->exclude('backup');
        foreach ($finder as $img){
            $array[] = $img->getRelativePathname();
        }
        return $array;
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
        $finder->files()->in($path.'/public/videos');
        foreach ($finder->name('*.mp4') as $file) {
            $fileNameWithExtension = $file->getRelativePathname();
            $filenameWithoutExtension = basename($file->getFilename(), '.'.$file->getExtension());
            $file_exists = $videosRepository->findBy(['file' => $fileNameWithExtension]);
            if (empty($file_exists)){
                $object = new Videos;
                $object->setFile($fileNameWithExtension)
                    ->setName($filenameWithoutExtension)
                    ->setEntryAt(new DateTimeImmutable())
                    ->setImgPoster($this->matchDbFileToExistingFile($path.'/public/img', $filenameWithoutExtension, 'jpg'))
                    ->setSubsFile($this->matchDbFileToExistingFile($path.'/public/subs', $filenameWithoutExtension, 'vtt'))
                    ->setVideoType('None');
                $videosRepository->add($object, true);
                $this->logger->info($fileNameWithExtension.' was added as Entry in Database');
            }else{
                $posterName = $file_exists[0]->getName();
                $subsName = $file_exists[0]->getName();
                $file_exists[0]->setImgPoster($this->matchDbFileToExistingFile($path.'/public/img', $posterName, 'jpg'))
                                ->setSubsFile($this->matchDbFileToExistingFile($path.'/public/subs', $subsName, 'vtt'));
                $this->doc->getManager()->persist($file_exists[0]);
                $this->doc->getManager()->flush();
            }
            $array[] = $fileNameWithExtension;
        }
        return $array;
    }


    /**
     * @param VideosRepository $videosRepository
     * @param array $videosArray
     * @return void
     */
    private function removeVideosFromDB(VideosRepository $videosRepository, array $videosArray ): void
    {
        $dbVideos = $videosRepository->findAll();
        foreach ($dbVideos as $dbVideo){
            if (!in_array($dbVideo->getFile(), $videosArray, true)){
                $videosRepository->remove($dbVideo, true);
                $this->logger->info($dbVideo->getFile().' was deleted from Database');
            }
        }
    }

    /**
     * @param String $path
     * @param String $fileName
     * @param String $ext
     * @return string
     */
    private function matchDbFileToExistingFile(String $path, String $fileName, String $ext): string
    {
        $fullName = $fileName.'.'.$ext;
        $finder = new Finder();
        $array = array();
        $finder->files()->in($path);
        foreach ($finder->name('*.'.$ext) as $img){
            $fileNameWithExtension = $img->getRelativePathname();
            $array[] = $fileNameWithExtension;
        }
        if (in_array($fullName, $array, true)){
            return $fullName;
        }
        $this->logger->info($fullName.' was not found , generic.'.$ext.' was given');
        return 'generic.'.$ext;
    }
}
