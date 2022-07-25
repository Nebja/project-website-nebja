<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\VideosRepository;
use App\Service\Helper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    private Serializer $serializer;
    private Helper $helper;

    public function __construct(Helper $helper)
    {
        $encoders = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizer, $encoders);
        $this->helper = $helper;

    }

    #[Route('/movies', name: 'movies')]
    public function movies(VideosRepository $videos): Response
    {
        $this->denyAccessUnlessGranted('ROLE_FRIEND');
        return new JsonResponse(array('toView' => $this->serializer->serialize(array('movies' => $videos->findAll()), 'json')));
    }
    #[Route('/addMovies', name: 'addMovies', methods: 'GET')]
    public function addMovies(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->helper->addNewMovieFiles($this->getParameter('kernel.project_dir'));
        return new JsonResponse(array('toView' => 'added'));
    }

    /**
     * @param ManagerRegistry $doc
     * @return Response
     */
    #[Route('/getUserInfo', name: 'getUserInfo')]
    public function getUserInfo(ManagerRegistry $doc): Response
    {
        $user = $doc->getManager()->getRepository(User::class)->findBy(['email' => $this->getUser()->getUserIdentifier()]);
        dump($user[0]);
        return new JsonResponse(array('data' => $this->serializer->serialize(array('user' => $user[0]), 'json')));
    }

    /**
     * @param TransportInterface $mailer
     * @param Request $request
     * @return Response
     */
    #[Route('/sendEmail', name: 'sendEmail')]
    public function sendEmail(TransportInterface  $mailer, Request $request): Response
    {

        $fromEmail = $request->get('email');
        $senderName = $request->get('name');
        $senderMsg = $request->get('message');
        $subject = $request->get('subject');

        $email = (new TemplatedEmail())
            ->from($fromEmail)
            ->to('nebwebsites@nebja.eu')
            ->cc($fromEmail)
            ->subject($subject)
            ->htmlTemplate('twig-assets/contactEmail.html.twig')
            ->context([
                'message' => $senderMsg,
                'name' => $senderName,
                'fromEmail' => $fromEmail
            ]);
        try {
            $mailer->send($email);
            $response = 'Your message was sent. I will try to contact you as soon as possible!';
        }catch (TransportExceptionInterface $e){
            $response = $e->getMessage();
        }
        return new JsonResponse(array('msg' => $response));
    }

}
