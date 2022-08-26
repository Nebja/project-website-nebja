<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    private Serializer $serializer;

    public function __construct (){
        $encoders = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $this->serializer =  new Serializer($normalizer, $encoders);
    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @param RequestStack $requestStack
     * @return Response
     */
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, RequestStack $requestStack, TranslatorInterface $translator): Response
    {
        $sessions = $requestStack->getSession();
        $translations = $translator->getCatalogue($sessions->get('lang'));
        if ($this->getUser()) {
            return $this->redirectToRoute('app_main', ['_locale' => $sessions->get('lang')]);
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('main/index.html.twig',[
            'page' => 'app' ,
            'toView' => $this->serializer->serialize(array(
                'lastEmail' => $authenticationUtils->getLastUsername(),
                'error' => $error?->getMessage(),
                'trans' => $this->serializer->serialize($translations->all()['messages'], 'json')),'json')
        ]);
    }
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
