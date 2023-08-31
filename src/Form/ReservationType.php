<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbConvive', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control input-nb',
                    'min'=> 1,
                    'max'=> 10,
                ],
                'required' => true,
                'label' => '',
                'label_attr' => [
                    'class' => 'mx-auto content-center ',
                    'placeholder' => 'Nombre de personnes',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
