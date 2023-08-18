<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Mot de passe actuel',
                'label_attr' => [
                    'class' => 'col-form-label mt-4'
                ],
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Nouveau mot de passe',
                    'label_attr' => [
                        'class' => 'col-form-label mt-2'
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'data-role'=>"input-pw",
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'col-form-label'
                    ],
                    'attr' => [
                        'class' => 'form-control mb-3',
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
            ]);
    }
}
