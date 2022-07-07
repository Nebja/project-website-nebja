<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploads
{
    private string $targetDirectory;
    private string $folder;

    public function __construct(String $targetDirectory, String $folder)
    {
        $this->targetDirectory = $targetDirectory;
        $this->folder = $folder;
    }

    /**
     * @param UploadedFile $file
     * @param String $filename
     * @return string[]
     */
    public function upload(UploadedFile $file, String $filename): array
    {
        if ($filename === ''){
            $filename = 'generic_'.uniqid('', true).$file->getExtension();
        }

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        try {
            $file->move($this->getTargetDirectory(), $filename.'.'.$file->guessExtension());
            return ['msg' => $originalFilename.' - Successfully Uploaded as "'.$filename.'" inside "'.$this->getTargetDirectory().'"', 'error' => false];
        } catch (FileException $e) {
            return ['msg' => $originalFilename.' was not Uploaded Reason: '.$e->getMessage(), 'error' => true];
        }
    }

    /**
     * @return String
     */
    public function getTargetDirectory(): string
    {
            return $this->targetDirectory.$this->folder;
    }
}
