<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints as Recapt;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => ' col-form-label mt-4'
                ],
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'required' => false,
                'label' => 'Prénom (facultatif)',
                'label_attr' => [
                    'class' => 'col-form-label mt-1'
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'minlength' => '2',
                    'maxlength' => '180'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'col-form-label mt-1'
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'first_options' => [
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'col-form-label mt-1'
                    ],
                    'attr' => [
                        'class' => 'form-control mb-3',
                        'data-role'=> "input-pw",
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
            ])
            ->add('tel', TelType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
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
                    'class' => 'form-control mb-3',
                    'min'=> 1,
                    'max'=> 10,
                ],
                'required' => false,
                'label' => 'Nombre de couvert(s)',
                'label_attr' => [
                    'class' => 'col-form-label mt-1'
                ],
            ])
            ->add('allergie', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'maxlength' => '500'
                ],
                'required' => false,
                'label' => 'Allergie(s) (500 car.)',
                'label_attr' => [
                    'class' => 'col-form-label mt-1'
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
            'data_class' => User::class,
        ]);
    }
}
