<?php

namespace GameBundle\Form;

use GameBundle\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
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
            ->add('nickname', TextType::class)
            ->add('password', RepeatedType::class,
                [
                    'type'=> PasswordType::class,
                    'first_options'=>
                        ['label'=>'Password:'],
                    'second_options'=>
                        ['label'=>'Repeat Password:'],
                    'invalid_message' => "Try again!"
                ]
            )
            ->add('email', EmailType::class)
            ->add('birthdate', BirthdayType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
            'data_class' => Player::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'game_bundle_player_type';
    }
}
