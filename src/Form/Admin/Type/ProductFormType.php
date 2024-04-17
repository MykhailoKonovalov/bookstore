<?php

namespace App\Form\Admin\Type;

use App\Constant\BookTypes;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'type', ChoiceType::class, [
                'choices' => BookTypes::toArray(),
                'attr' => [
                    'class' => 'js-book-type',
                ],
            ])
            ->add('price', MoneyType::class, [
                'currency' => Product::CURRENCY_CODE,
                'divisor' => 100,
            ])
            ->add('discountPrice', MoneyType::class, [
                'currency' => Product::CURRENCY_CODE,
                'divisor' => 100,
            ])
            ->add('discountPercent', PercentType::class, [
                'type' => 'integer',
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $product = $event->getData();
            $form = $event->getForm();

            if ($product instanceof Product && BookTypes::ELECTRONIC->value === $product->getType()) {
                $form
                    ->add('eBookFormats', CollectionType::class, [
                        'entry_type' => EBookFormatFormType::class,
                        'label' => false,
                        'by_reference' => false,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'attr' => [
                            'class' => 'js-book-formats',
                        ],
                    ]
                );
            }
        });
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults(
                [
                    'data_class' => Product::class,
                ]);
    }
}