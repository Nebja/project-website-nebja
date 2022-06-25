<?php

namespace App\Controller;

use App\Repository\VideosRepository;
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

    public function __construct (){
        $encoders = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $this->serializer =  new Serializer($normalizer, $encoders);
    }
    #[Route('/movies', name: 'movies')]
    public function movies(VideosRepository $videos): Response
    {
        $this->denyAccessUnlessGranted('ROLE_FRIEND');

        return new JsonResponse(array('toView' => $this->serializer->serialize(array('movies' => $videos->findAll()), 'json')));
    }
}
