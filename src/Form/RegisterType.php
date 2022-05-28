<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label'=>'votre email',
                'attr'=> [
                    'placeholder'=>'dupont@dupond.com'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=>'Le mot de passe et la confirmation doivent être indentique',
                'label'=>'Votre mot de passe',
                'required'=>true,
                'first_options'=>['label'=>'votre mot de passe'],
                'second_options'=> ['label'=>'Confirmez votre mot de passe']
            ])
            ->add('submit', SubmitType::class, [
                'label'=>"s'incrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
