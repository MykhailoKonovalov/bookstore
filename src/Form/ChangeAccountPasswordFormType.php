<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangeAccountPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Current Password',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(
                        [
                            'message' => 'Please enter a password',
                        ],
                    ),
                    new Length(
                        [
                            'min'        => 12,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            'max'        => 4096,
                        ],
                    ),
                ],
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'New Password',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(
                        [
                            'message' => 'Please enter a password',
                        ],
                    ),
                    new Length(
                        [
                            'min'        => 12,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            'max'        => 4096,
                        ],
                    ),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirm Password',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(
                        [
                            'message' => 'Please enter a password',
                        ],
                    ),
                    new Length(
                        [
                            'min'        => 12,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            'max'        => 4096,
                        ],
                    ),
                ],
            ]);
    }
}