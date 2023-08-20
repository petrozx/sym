<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculatePriceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', ChoiceType::class, [
                'choices' => ['Iphone' => 1, 'Наушники' => 2, 'Чехол' => 3],
            ])
            ->add('taxNumber')
            ->add('couponCode')
            ->add('paymentProcessor', ChoiceType::class, [
                'choices' => ['paypal' => 'Paypal', 'stripe' => 'Stripe'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // ...
        ]);
    }
}