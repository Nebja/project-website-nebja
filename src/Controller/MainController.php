<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\VideosRepository;
use Doctrine\Persistence\ManagerRegistry;
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
     * @param ManagerRegistry $doc
     * @return Response
     */
    #[Route('', name: 'main')]
    public function index(ManagerRegistry $doc): Response
    {
        if ($this->getUser() !== null ){
            $user = $doc->getManager()->getRepository(User::class)->findBy(['email' => $this->getUser()->getUserIdentifier()]);
            $verify = $user[0]->isVerified();
            if(!$verify){
                $this->addFlash('notice', 'Please verify your email . For new link click here <a href="/verify/newEmail">NEW LINK</a>');
            }
        }
        return $this->render('main/index.html.twig', [
            'page' => 'app' ,
            'toView' => $this->serializer->serialize(array(
                'user' => $this->getUser() !== null ? $this->getUser()->getUserIdentifier() : null,
                'role' => $this->getUser() !== null ? $this->getUser()->getRoles() : null
            ),'json')
        ]);
    }

    /**
     * @param int $id
     * @param VideosRepository $video
     * @return Response
     */
    #[Route('/movies/{id}', name: 'movies')]
    public function movies(int $id, VideosRepository $video): Response
    {
        $this->denyAccessUnlessGranted('ROLE_FRIEND');

        return $this->render('main/index.html.twig', [
            'page' => 'videos',
            'video' => $this->serializer->serialize($video->find($id), 'json')
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
        $sendVar = 'The Variable is :'. $getVar;
        return new JsonResponse(array('testData' => $sendVar));
    }
}
