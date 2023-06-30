<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
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
        $user = $options['user'];
        $builder
        ->add('nom', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => '2',
                'maxlength' => '50'
            ],
            'label' => 'Nom',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 50]),
            ],
        ])
        ->add('prenom', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => '2',
                'maxlength' => '50'
            ],
            'required' => false,
            'label' => 'Prénom (facultatif)',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Length(['min' => 2, 'max' => 50]),
            ],
        ])
        ->add('tel', TelType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => '10',
                'maxlength' => '14'
            ],
            'label' => 'Téléphone',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 10, 'max' => 14]),
            ],
        ])
        ->add('nbConvive', IntegerType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'required' => false,
            'label' => 'Nombre de convive',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
        ])
        ->add('allergie', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'maxlength' => '500'
            ],
            'required' => false,
            'label' => 'Allergie',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Length(['max' => 500]),
            ],
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
