<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserAccountFormData extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name', TextType::class, [
                'constraints' => [
                    new NotBlank(
                        [
                            'message' => 'Please enter your name',
                        ],
                    ),
                ],
            ],
            )
            ->add(
                'email', EmailType::class, [
                'constraints' => [
                    new Email(
                        [
                            'message' => 'Please enter a valid email address',
                        ],
                    ),
                ],
            ],
            )
            ->add(
                'phone', TextType::class, [
                'constraints' => [
                    new NotBlank(
                        [
                            'message' => 'Please enter your phone number',
                        ],
                    ),
                ],
            ],
        );
    }
}