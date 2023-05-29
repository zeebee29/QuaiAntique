<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints as Recapt;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbConvive', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
                'label' => ' ',
                'label_attr' => [
                    'class' => 'mx-auto resa-field content-center',
                    'placeholder' => 'Nombre de personnes',
                ],
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recapt\Recaptcha3(),
                'action_name' => 'inscription',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
