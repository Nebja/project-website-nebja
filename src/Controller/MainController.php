<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_')]
class MainController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route('', name: 'main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    /**
     * @param MailerInterface $mailer
     * @return JsonResponse
     * @throws TransportExceptionInterface
     */
    #[Route('/send', name: 'send')]
    public function sendEmail(MailerInterface $mailer): JsonResponse
    {
        $email = (new Email())
            ->from('no-reply@nebja.eu')
            ->to('benjaminkotsaridis@outlook.com.gr')
            ->subject('Symfony Mailer')
            ->text('Test email for Mailer Symfony')
            ->html('<p>See Twig integration for better HTML integration!</p>');
        $mailer->send($email);
        return new JsonResponse(array('mail' => 'send'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/json', name: 'json', methods: ['GET', 'POST'])]
    public function jsonMsg(Request $request): JsonResponse
    {
        dump($request);
        $getVar = $request->get('testVar');
        $sendVar = 'The Variable is :'. $getVar;
        return new JsonResponse(array('testData' => $sendVar));
    }
}
