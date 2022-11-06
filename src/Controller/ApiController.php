<?php

namespace App\Controller;

use App\Repository\HomeRepository;
use App\Repository\UserRepository;
use App\Repository\VideosRepository;
use App\Service\Helper;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
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
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    private Serializer $serializer;
    private Helper $helper;
    private UserRepository $userRepository;
    private EntityManagerInterface $em;
    private TranslatorInterface $translator;

    public function __construct(Helper $helper, UserRepository $userRepo, EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $encoders = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizer, $encoders);
        $this->helper = $helper;
        $this->userRepository = $userRepo;
        $this->em = $em;
        $this->translator = $translator;

    }

    #[Route('/movies', name: 'movies')]
    public function movies(VideosRepository $videos): Response
    {
        $this->denyAccessUnlessGranted('ROLE_FRIEND');
        $series = $videos->findBy(['videoType' => 'Episode']);
        $seriesArray = [];
        foreach ($series as $episode){
            $seriesName = explode('/',$episode->getFile())[0];
            $seriesArray[$seriesName]['name'] = $seriesName;
            $seriesArray[$seriesName]['episodes'][] = $episode;
            $seriesArray[$seriesName]['poster'] = $episode->getImgPoster();
        }
        return new JsonResponse(array('toView' => $this->serializer->serialize(array('movies' => $videos->findBy(['videoType' => 'Movie']), 'series' => $seriesArray), 'json')));
    }
    #[Route('/addMovies', name: 'addMovies', methods: 'GET')]
    public function addMovies(VideosRepository $videosRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->helper->addNewMovieFiles($this->getParameter('kernel.project_dir'), $videosRepository);
        return new JsonResponse(array('toView' => 'added'));
    }
    #[Route('/addHomeMovies', name: 'addHomeMovies', methods: 'GET')]
    public function addHomeMovies(HomeRepository $homeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->helper->addNewHomeMovies($this->getParameter('kernel.project_dir'), $homeRepository);
        return new JsonResponse(array('toView' => 'added'));
    }

    /**
     * @return Response
     */
    #[Route('/getUserInfo', name: 'getUserInfo')]
    public function getUserInfo(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->userRepository->findBy(['email' => $this->getUser()?->getUserIdentifier()]);
        return new JsonResponse(array('data' => $this->serializer->serialize(array('user' => $user[0]), 'json')));
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/editEmail', name: 'editEmail')]
    public function editEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $infoArr = [
            'id' => $request->get('id'),
            'email' => $request->get('email'),
            'username' => $request->get('username'),
            'agreement' => $request->get('agree')==='true'?1:0
        ];
        $user = $this->userRepository->find($infoArr['id']);
        if (!$user){
            $this->addFlash('error', $this->translator->trans('accountPage.noUser').': '.$infoArr['id']);
            return new JsonResponse(array('data' => 'error'));
        }
        try {
            $user->setEmail($infoArr['email'])
                ->setUsername($infoArr['username'])
                ->setAgreement($infoArr['agreement']);
            $this->em->flush();
        }catch (\Exception $e){
            $this->addFlash('error', $this->translator->trans('accountPage.accError'));
            return new JsonResponse(array('data' => $e->getMessage()));
        }
        return new JsonResponse(array('data' => 'updated', 'info' => $infoArr));
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/deleteAccount', name: 'deleteAccount')]
    public function deleteAccount(Request $request): Response
    {

        $user = $this->userRepository->find($request->get('id'));
        if ($user?->getEmail() !== $this->getUser()?->getUserIdentifier()){
            return new JsonResponse(array('msg' => $this->translator->trans('accountPage.notOwner').' '.$user?->getEmail().$this->translator->trans('accountPage.notOwner2')));
        }

        try {
            $this->userRepository->remove($user, true);
            $request->getSession()->invalidate();
            $this->container->get('security.token_storage')->setToken(null);
            $this->addFlash('notice', $this->translator->trans('accountPage.accDeleted'));
        }catch (Exception|NotFoundExceptionInterface|ContainerExceptionInterface $e){
            $this->addFlash('notice', $this->translator->trans('accountPage.accError'));
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
            ->from('support@nebweb.eu')
            ->to('support@nebweb.eu')
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
            $response = $this->translator->trans('contactPage.emailSent');
        }catch (TransportExceptionInterface $e){
            $response = $e->getMessage();
        }
        return new JsonResponse(array('msg' => $response));
    }

}
