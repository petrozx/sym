<?php
namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', ChoiceType::class, [
                'choices' => ['Iphone' => 1, 'Headphones' => 2, 'Case' => 3],
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
            'data_class' => Order::class
        ]);
    }
}