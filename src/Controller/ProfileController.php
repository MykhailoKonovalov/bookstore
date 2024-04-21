<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangeAccountPasswordFormType;
use App\Form\DeleteAccountFormType;
use App\Form\UserAccountFormData;
use App\Service\Entity\EntityHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityHelper $entityHelper,
    ) {}

    #[Route('/profile/account', name: 'profile_account')]
    public function account(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(UserAccountFormData::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityHelper->save($user);

            return $this->redirectToRoute('profile_account');
        }

        return $this->render(
            'profile/account.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/profile/change-password', name: 'profile_change_password')]
    public function changePassword(Request $request): Response
    {
        $form = $this->createForm(ChangeAccountPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user            = $this->getUser();
            $oldPassword     = $form->get('currentPassword')->getData();
            $newPassword     = $form->get('newPassword')->getData();
            $confirmPassword = $form->get('confirmPassword')->getData();

            if (!$this->userPasswordHasher->isPasswordValid($user, $oldPassword)) {
                $this->addFlash('error', 'Incorrect current password.');

                return $this->redirectToRoute('profile_change_password');
            }

            if ($newPassword === $confirmPassword) {
                $user->setPassword(
                    $this->userPasswordHasher->hashPassword($user, $newPassword)
                );

                $this->entityHelper->save($user);

                $this->addFlash('success', 'Password changed successfully.');
            } else {
                $this->addFlash('error', 'New passwords do not match.');
            }

            return $this->redirectToRoute('profile_change_password');
        }

        return $this->render(
            'profile/changePassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile/delete', name: 'profile_delete')]
    public function delete(Request $request): Response
    {
        $form = $this->createForm(DeleteAccountFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            if ($form->get('confirm')->getData()) {
                $this->entityHelper->deleteOne($user);

                return $this->redirectToRoute('logout');
            }
        }

        return $this->render(
            'profile/delete.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/private/user-block', name: 'user_block', methods: ['GET'])]
    #[Cache(expires: 3600, public: true, mustRevalidate: true)]
    public function userBlock(): Response
    {
        return $this->render(
            'components/userBlock.html.twig', [
            'currentUser' => $this->getUser(),
        ]);
    }
}
