<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class Reservation3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('dateReservation', DateTimeType::class, [
            'label' => 'Le : ',
            'attr'=> [
                'readonly' => 'readonly',
                'class' => 'readonly-field input-nb'
            ],
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'yyyy-MM-dd HH:mm:ss',
            'required' => true,
            'label_attr' => [
                'class' => 'label-visible resa3-input-label',
            ],            
        ])
        ->add('nbConvive',NumberType::class,[
            'label' => 'Nbre de couvert(s) :',
            'attr'=> [
                'readonly' => 'readonly',
                'class' => 'readonly-field input-nb'
            ],
            'label_attr' => [
                'class' => 'label-visible resa3-input-label',
            ],            
        ])
        ->add('allergie', TextType::class,[
            'label' => 'Allergie à signaler :',
            'required' => false,
            'label_attr' => [
                'class' => 'label-visible resa3-input-label',
            ],            
        ])
        ->add('midiSoir',TextType::class,[
            'attr' => [
                'hidden'=>true,
            ],
            'label_attr' => [
                'hidden' => true,
            ],            
        ])
        ->add('telReserv', TelType::class, [
            'label' => 'Téléphone : ',
            'attr'=> [
                'class' => 'input-nb',
            ],
            'required' => true,
            'label_attr' => [
                'class' => 'label-visible resa3-input-label',
            ],            
            'constraints'=> [
                new NotBlank(),
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => 'email : ',
            'attr'=> [
                'class' => 'input-nb'
            ],
            'required' => true,
            'label_attr' => [
                'class' => 'label-visible resa3-input-label',
            ],            
        ]);

        //Remise en format des date et heure avant soumission
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            if (isset($data['dateReservation'])) {
                $dateReservation = \DateTime::createFromFormat('d/m/Y - H:i', $data['dateReservation']);
                $data['dateReservation'] = $dateReservation->format('Y-m-d H:i:s');
            }
            if (isset($data['telReserv'])) {
                $data['telReserv'] = str_replace(' ', '', $data['telReserv']);
            }
            $event->setData($data);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            "allow_extra_fields" => true,
        ]);
    }
}
