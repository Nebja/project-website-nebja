<?php

namespace App\Controller;


use App\Service\FileManager;
use App\Service\Uploads;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    private FileManager $filesystem ;
    public function __construct()
    {
        $this->filesystem = new FileManager();
    }
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/files', name: 'files')]
    public function getFiles(): Response
    {
        $this->filesystem->setProjectDir($this->getParameter('kernel.project_dir').'/public/');
        return new JsonResponse($this->filesystem->serverFiles());
    }
    #[Route('/upload', name: 'upload')]
    public function uploadFile(Request $request): Response
    {
        $files = $request->files->get('file');
        $folder = $request->get('folder');
        $filename =  $request->get('name');

        $fileUpload = new Uploads($this->getParameter('kernel.project_dir').'/public/', $folder);
        $answer= $fileUpload->upload($files, $filename);
        return new JsonResponse(array('message' => $answer['msg'], 'error' => $answer['error']));

    }
    #[Route('/delete', name: 'delete')]
    public function deleteFile(Request $request): Response
    {
        $this->filesystem->setProjectDir($this->getParameter('kernel.project_dir').'/public/');
        return new JsonResponse($this->filesystem->removeFile($request->get('file')));
    }
    #[Route('/test', name: 'test')]
    public function test(Request $request): Response
    {
        return new JsonResponse(array('data' => $request->files->get('data')));
    }
}
