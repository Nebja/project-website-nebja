<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $entityManager
     * @param TransportInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request,UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, TransportInterface $mailer): Response
    {

        $user = new User();
        $user->setEmail($request->get('email'))
             ->setRoles(array("ROLE_USER"))
             ->setAgreement(($request->get('agreement') === 'false' ? 0 : 1))
             ->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $request->get('password')));
        $entityManager->persist($user);
        try {
            $entityManager->flush();
        }catch (Exception $e) {
            return new JsonResponse(array('msg' => 'A profile with the current Email Exists'));
        }
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('no-reply@nebja.eu', 'Nebja Mail Bot'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
        $inform = (new Email())
            ->from('no-reply@nebja.eu')
            ->to('nebwebsites@nebja.eu')
            ->subject('New Registration from '.$user->getEmail())
            ->text('New Registration Email')
            ->html('New Registration with Email: '.$user->getEmail().'! (Dont Forget to check the Role)');
        $mailer->send($inform);
        return new JsonResponse(array('msg' => 'User registered , please confirm Your email.'));
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        if ($this->getUser() === null){
            $this->addFlash('notice', 'Please login first and then click the link');
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        }
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
            return $this->redirectToRoute('app_main');
        }
        $this->addFlash('success', 'Your email address has been verified.');
        return $this->redirectToRoute('app_main');
    }

    /**
     * @param ManagerRegistry $doc
     * @return RedirectResponse
     */
    #[Route('/verify/newEmail', name: 'app_new_verify_email')]
    public function new_Link(ManagerRegistry $doc): RedirectResponse
    {
        if ($this->getUser() === null){
            $this->addFlash('notice', 'Please login first and then ask for new Link ');
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        }
        $user = $doc->getManager()->getRepository(User::class)->findBy(['email' => $this->getUser()->getUserIdentifier()]);

        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user[0],
            (new TemplatedEmail())
                ->from(new Address('no-reply@nebja.eu', 'Nebja Mail Bot'))
                ->to($user[0]->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
        return $this->redirectToRoute('app_main');
    }
}
