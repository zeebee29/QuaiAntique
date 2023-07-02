<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

use Symfony\Component\Validator\Constraints as Assert;
class Reservation3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('dateReservation', DateTimeType::class, [
            /*'attr' => ['hidden' => 'hidden'],*/
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'yyyy-MM-dd HH:mm',
            'required' => true,
        ])
                ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4',
            ]
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            
        ]);
    }
}
