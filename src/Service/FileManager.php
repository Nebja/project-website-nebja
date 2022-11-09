<?php

namespace App\Service;

use App\Entity\Home;
use App\Entity\Videos;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileManager
{
    private Filesystem $filesystem;
    private String $projectDir;
    private ManagerRegistry $doc;

    public function __construct(ManagerRegistry $doc)
    {
        $this->projectDir = 'none';
        $this->filesystem = new Filesystem();
        $this->doc = $doc;
    }

    /**
     * @param String $projectDir
     * @return void
     */
    public function setProjectDir(String $projectDir): void
    {
        $this->projectDir = $projectDir;
    }

    /**
     * @param string $folder
     * @return array
     */
    public function serverFiles(string $folder): array
    {
        $response = [];
        if ($folder === ''){
            $search_folders = ['img', 'Videos', 'subs', 'Home'];
            foreach ($search_folders as $one_folder){
                if (file_exists($this->projectDir.$one_folder)){
                    $response[$one_folder]= $this->findFiles($one_folder);
                }
            }
        }else{
            $response[$folder]= $this->findFiles($folder, false);
        }
        return $response;
    }

    /**
     * @param String $file
     * @return array
     */
    #[ArrayShape(['message' => "string", 'error' => "bool"])]
    public function removeFile(String $file): array
    {
        try {
            $this->filesystem->remove([$this->projectDir.$file]);
            $answer= 'File Deleted';
            $error = false;
        }catch (FileException $e){
            $answer= $e->getMessage();
            $error = true;
        }
        return array('message' => $answer, 'error' => $error);
    }

    /**
     * @param String $folder
     * @param bool $all
     * @return array
     */
    private function findFiles(String $folder, bool $all=true): array
    {
        if (!($all)){
            $current_folder = $folder === 'Home' || $folder === 'Videos' ? '' : $folder;
        }else{
            $current_folder = $folder === 'img' ? 'img/posters' : $folder;
        }
        $finder = new Finder();
        $files = array();
        $finder->depth($folder==='Videos'?'< 2': '== 0')->files()->in($this->projectDir.$current_folder);
        foreach ($finder->files() as $file){
            if ($folder === 'Videos' || $folder === 'Home'){
                $searched_file = $this->searchInDB($folder,$file->getRelativePathname());
                if (empty($searched_file)){
                    $files[] = ['file' => $file->getRelativePathname(),'name' => 'NONE','comment' => 'Not registered in DB'];
                }else{
                    $files[] = $searched_file[0];
                }
            }else{
                $files[] = ['name' => $file->getRelativePathname()];
            }
        }
        return $files;
    }

    /**
     * @param string $folder
     * @param string $file
     * @return array|Home
     */
    private function searchInDB(string $folder, string $file): array|Home
    {
        return match ($folder) {
            'Videos' => $this->doc->getRepository(Videos::class)->findByFile($file),
            'Home' => $this->doc->getRepository(Home::class)->findByFile($file),
            default => ['NONE'],
        };
    }
}
