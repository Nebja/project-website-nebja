<?php

namespace App\Controller;

use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/', name: 'app_')]
class MainController extends AbstractController
{
    private Serializer $serializer;

    public function __construct (){
        $encoders = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $this->serializer =  new Serializer($normalizer, $encoders);
    }

    /**
     * @return Response
     * @throws JsonException
     */
    #[Route('', name: 'main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'toView' => $this->serializer->serialize(json_decode(json_encode(array(
                'user' => $this->getUser() !== null ? $this->getUser()->getUserIdentifier() : null,
                'role' => $this->getUser() !== null ? $this->getUser()->getRoles() : null), JSON_THROW_ON_ERROR), FALSE, 512, JSON_THROW_ON_ERROR),
                'json')
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
    #[Route('/json', name: 'json', methods: ['POST'])]
    public function jsonMsg(Request $request): JsonResponse
    {
        $getVar = $request->get('testVar');
        dump($request->query->all());
        $sendVar = 'The Variable is :'. $getVar;
        return new JsonResponse(array('testData' => $sendVar));
    }
}
