<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'col-form-label mt-4'
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
                    'class' => 'col-form-label mt-1'
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
                    'class' => 'col-form-label mt-1'
                ],
            ])
            ->add('nbConvive', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
                'label' => 'Nombre de couvert(s)',
                'label_attr' => [
                    'class' => 'col-form-label mt-1'
                ],
            ])
            ->add('allergie', TextType::class, [
                'attr' => [
                    'class' => 'form-control  mb-3',
                    'maxlength' => '500'
                ],
                'required' => false,
                'label' => 'Allergie',
                'label_attr' => [
                    'class' => 'col-form-label mt-1'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
