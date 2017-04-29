<?php

namespace GameBundle\Form;

use GameBundle\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname', TextType::class,
                [
                    'required' => true,
                    'label' => 'Nickname:',
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ])
            ->add('password', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' =>
                        [
                            'label' => 'Password:',
                            'error_bubbling' => true,
                            'attr' =>
                                [
                                    'class' => 'form-control'
                                ]
                        ],
                    'second_options' =>
                        [
                            'label' => 'Repeat Password:',
                            'error_bubbling' => true,
                            'attr' =>
                                [
                                    'class' => 'form-control'
                                ]
                        ],
                    'invalid_message' => "Passwords don't match!",
                    'error_bubbling' => true,
                    'required' => true
                ]
            )
            ->add('email', EmailType::class,
                [
                    'required' => true,
                    'label' => 'E-mail:',
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ])
            ->add('birthdate', BirthdayType::class,
                [
                    'label' => 'Born on:',
                    'required' => true
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Player::class,
                "validation_groups" =>
                    [
                    "Default", "Registration"
                    ]
            ]);
    }

    public function getBlockPrefix()
    {
        return 'game_bundle_player_type';
    }
}
