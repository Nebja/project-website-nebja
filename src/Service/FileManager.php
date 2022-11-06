<?php

namespace App\Service;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileManager
{
    private Filesystem$filesystem;
    private String $projectDir;

    public function __construct()
    {
        $this->projectDir = 'none';
        $this->filesystem = new Filesystem();
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
     * @return array
     */
    public function serverFiles(): array
    {
        $response['images']= $this->findFiles('img');
        $response['videos']= $this->findFiles('Videos');
        $response['subs']= $this->findFiles('subs');
        $response['home']= $this->findFiles('Home');
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
     * @return array
     */
    private function findFiles(String $folder): array
    {
        $finder = new Finder();
        $files = array();
        $finder->files()->in($this->projectDir.$folder);
        foreach ($finder->files() as $file){
            $files[] = ['name' => $file->getRelativePathname()];
        }
        return $files;
    }
}
