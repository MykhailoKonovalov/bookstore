<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Service\Email\EmailSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/reset-password')]
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    public function __construct(
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly EntityManagerInterface $entityManager,
        private readonly EmailSender $sender,
    ) {}

    #[Route(name: 'forgot_password_request')]
    public function request(Request $request, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData(),
                $translator,
            );
        }

        return $this->render(
            'security/reset_password/request.html.twig', [
            'requestForm' => $form,
        ]);
    }

    #[Route('/check-email', name: 'check_email')]
    public function checkEmail(): Response
    {
        if (!($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render(
            'security/reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }

    #[Route('/reset/{token}', name: 'reset_password')]
    public function reset(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        TranslatorInterface $translator,
        ?string $token = null,
    ): Response {
        if ($token) {
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('reset_password');
        }

        if (!$token = $this->getTokenFromSession()) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        try {
            /** @var PasswordAuthenticatedUserInterface $user */
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash(
                'reset_password_error', sprintf(
                '%s - %s',
                $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE, [], 'ResetPasswordBundle'),
                $translator->trans($e->getReason(), [], 'ResetPasswordBundle'),
            ));

            return $this->redirectToRoute('forgot_password_request');
        }

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resetPasswordHelper->removeResetRequest($token);

            $encodedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData(),
            );

            $user->setPassword($encodedPassword);
            $this->entityManager->flush();

            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('home');
        }

        return $this->render(
            'security/reset_password/reset.html.twig', [
            'resetForm' => $form,
        ]);
    }

    private function processSendingPasswordResetEmail(
        string $emailFormData,
        TranslatorInterface $translator,
    ): RedirectResponse {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(
            [
                'email' => $emailFormData,
            ],
        );

        if (!$user) {
            return $this->redirectToRoute('check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $exception) {
            $this->addFlash(
                'reset_password_error', sprintf(
                '%s - %s',
                $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_HANDLE, [], 'ResetPasswordBundle'),
                $translator->trans($exception->getReason(), [], 'ResetPasswordBundle'),
            ));

            return $this->redirectToRoute('check_email');
        }

        $this->sender->send(
            $user->getEmail(),
            'Your password reset request',
            'security/reset_password/email.html.twig',
            [
                'resetToken' => $resetToken,
            ],
        );

        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('check_email');
    }
}
