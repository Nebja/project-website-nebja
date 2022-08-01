<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/reset-password')]
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private ResetPasswordHelperInterface $resetPasswordHelper;
    private EntityManagerInterface $entityManager;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper, EntityManagerInterface $entityManager)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
        $this->entityManager = $entityManager;
    }

    /**
     * Display & process form to request a password reset.
     */
    #[Route('', name: 'app_forgot_password_request')]
    public function request(Request $request, TransportInterface $mailer, TranslatorInterface $translator): Response
    {
        $resetArray =  $this->processSendingPasswordResetEmail(
            $request->get('email'),
            $mailer,
            $translator
        );
        $view = $this->renderView('reset_password/check_email.html.twig',[
            'resetToken' => $resetArray['resetToken'],
            'error'      => $resetArray['error']
        ]);
        return new JsonResponse(array('view' => $view));
    }

    /**
     * Confirmation page after a user has requested a password reset.
     */
    /*
    #[Route('/check-email', name: 'app_check_email')]
    public function checkEmail(): Response
    {
        // Generate a fake token if the user does not exist or someone hit this page directly.
        // This prevents exposing whether or not a user was found with the given email address or not
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }
        $view = $this->renderView('reset_password/check_email.html.twig',[
            'resetToken' => $resetToken,
        ]);
        return new JsonResponse(array('view' => $view));
    }*/

    /**
     * Validates and process the reset URL that the user clicked in their email.
     */
    #[Route('/reset/{token}', name: 'app_reset_password')]
    public function reset(Request $request, UserPasswordHasherInterface $userPasswordHasher, TranslatorInterface $translator, string $token = null): Response
    {
        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('app_reset_password');
        }
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $token = $this->getTokenFromSession();
        if (null === $token) {
            return $this->render('main/index.html.twig', [
                'page' => 'app' ,
                'toView' => $serializer->serialize(array(
                    'user' => null,
                    'role' => null,
                    'form' => 'You have no access in this page , contact an Administrator'
                ),'json')
            ]);
        }

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                '%s - %s',
                $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE, [], 'ResetPasswordBundle'),
                $translator->trans($e->getReason(), [], 'ResetPasswordBundle')
            ));
            return $this->render('main/index.html.twig', [
                'page' => 'app' ,
                'toView' => $serializer->serialize(array(
                    'user' => null,
                    'role' => null
                ),'json')
            ]);
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            // Encode(hash) the plain password, and set it.
            $encodedPassword = $userPasswordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);
            $this->entityManager->flush();
            $this->cleanSessionAfterReset();
            return $this->render('main/index.html.twig', [
                'page' => 'app' ,
                'toView' => $serializer->serialize(array(
                    'user' => null,
                    'role' => null,
                    'form' => 'Your Password was Changed. Login with your new password!'
                ),'json')
            ]);
        }
        $form = $this->renderView('reset_password/reset.html.twig',['resetForm' => $form->createView()]);
        return $this->render('main/index.html.twig', [
            'page' => 'app' ,
            'toView' => $serializer->serialize(array(
                'user' => null,
                'role' => null,
                'form' => $form
            ),'json')
        ]);
    }

    private function processSendingPasswordResetEmail(string $emailFormData, TransportInterface $mailer, TranslatorInterface $translator): array
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);
        if (!$user) {
            if (null === ($resetToken = $this->getTokenObjectFromSession())) {
                $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
            }
            return array('resetToken' => $resetToken, 'error' => 'No user found with this email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            $error = sprintf('%s - %s',
                $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_HANDLE, [], 'ResetPasswordBundle'),
                $translator->trans($e->getReason(), [], 'ResetPasswordBundle'));
            if (null === ($resetToken = $this->getTokenObjectFromSession())) {
                $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
            }

            return array('resetToken' => $resetToken, 'error' => $error);

        }

        $email = (new TemplatedEmail())
            ->from(new Address('nebwebsites@nebja.eu', 'NebWeb Mail Bot'))
            ->to($user->getEmail())
            ->subject('Your password reset request')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ])
        ;

        $mailer->send($email);

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }
        return array('resetToken' => $resetToken, 'error' => false);
    }
}
