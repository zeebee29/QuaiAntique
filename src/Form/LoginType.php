<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email", EmailType::class, [
                'label' => 'Adresse email :',
                'required' => true,
                'attr'=> [
                    'class' => "input-nb form-control input-nb",
                ],
                'label_attr' => [
                    'class' => 'col-form-label',
                ],            
            ])
            ->add("password", PasswordType::class, [
                "label" => "Mot de passe :",
                "required" => true,
                'attr' => [
                    'data-role'=> "input-pw",
                ],
                'label_attr' => [
                    'class' => 'col-form-label',
                ],                 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => User::class,
        ]);
    }
}