<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\VideosRepository;
use App\Service\Helper;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $doc->getManager()->getRepository(User::class)->findBy(['email' => $this->getUser()->getUserIdentifier()]);
        return new JsonResponse(array('data' => $this->serializer->serialize(array('user' => $user[0]), 'json')));
    }

    /**
     * @param Request $request
     * @param ManagerRegistry $doc
     * @return Response
     */
    #[Route('/editEmail', name: 'editEmail')]
    public function editEmail(Request $request, ManagerRegistry $doc): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $email = $request->get('email');
        $id = $request->get('id');
        $agree = $request->get('agree');
        $user = $doc->getManager()->find(User::class, $id);
        if (!$user){
            throw $this->createNotFoundException(
              'No user Found with id: '.$request->get('id')
            );
        }
        $user->setEmail($email)
                ->setAgreement($agree===true?1:0);
        $doc->getManager()->flush();
        return new JsonResponse(array('data' => 'updated'));
    }

    /**
     * @param ManagerRegistry $doc
     * @param Request $request
     * @return Response
     */
    #[Route('/deleteAccount', name: 'deleteAccount')]
    public function deleteAccount(ManagerRegistry $doc, Request $request): Response
    {

        $user = $doc->getManager()->find(User::class, $request->get('id'));
        if ($user->getEmail() !== $this->getUser()->getUserIdentifier()){
            return new JsonResponse(array('msg' => 'You are not the owner of the account with email '.$user->getEmail().' , please contact an Administrator'));
        }
        try {
            $doc->getManager()->getRepository(User::class)->remove($user, true);
            $request->getSession()->invalidate();
            $this->container->get('security.token_storage')->setToken(null);
            $this->addFlash('notice', 'We are sad to see you go but your account was delete.');
        }catch (Exception|NotFoundExceptionInterface|ContainerExceptionInterface $e){
            $this->addFlash('notice', 'We encountered an error , please contact an Administrator');
        }
        return $this->render('main/index.html.twig', [
            'page' => 'app' ,
            'toView' => $this->serializer->serialize(array(
                'user' => null,
                'role' => null
            ),'json')
        ]);
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
