<?php

namespace App\Controller;

use App\Repository\VideosRepository;
use App\Service\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    private Serializer $serializer;
    private Helper $helper;
    public function __construct (Helper $helper){
        $encoders = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $this->serializer =  new Serializer($normalizer, $encoders);
        $this->helper = $helper;

    }
    #[Route('/movies', name: 'movies')]
    public function movies(VideosRepository $videos): Response
    {
        $this->denyAccessUnlessGranted('ROLE_FRIEND');
        $this->helper->addNewMovieFiles($this->getParameter('kernel.project_dir'));
        return new JsonResponse(array('toView' => $this->serializer->serialize(array('movies' => $videos->findAll()), 'json')));
    }
    /**
     * @param int $id
     * @param VideosRepository $video
     * @return Response
     */
    #[Route('/images', name: 'images')]
    public function images(): Response
    {
        dump('images');
        $images = $this->helper->getCarouselImages($this->getParameter('kernel.project_dir'));
        return new JsonResponse(array('images' => $images));
    }
}
