<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('password', PasswordType::class, [
        'help' => 'Le mot de passe doit contenir entre 8 et 50 caractere.',
    ])
            ->add('confirm_password', PasswordType::class)
            ->add('role', EntityType::class, [
                'class' => Role::class,
                'label' => 'Role de l\'utilisateur'
            ])
            ->add('name')
            ->add('projects')
            ->add('picture')
            ->add('website')
            ->add('facebook')
            ->add('twitter')
            ->add('registrationDate', null, [
            'widget' => 'single_text',
        ]);

        

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
