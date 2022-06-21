<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SecurityController extends AbstractController
{
    private Serializer $serializer;

    public function __construct (){
        $encoders = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $this->serializer =  new Serializer($normalizer, $encoders);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils , Request $request ): Response
    {
        if ($this->getUser()) {
            return new JsonResponse(array('user' => $this->getUser()));
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('main/index.html.twig',[
            'toView' => $this->serializer->serialize(json_decode(json_encode(array(
                'lastEmail' => $authenticationUtils->getLastUsername(),
                'error' => $error?->getMessage())),
                FALSE),
                'json')
        ]);
    }
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
