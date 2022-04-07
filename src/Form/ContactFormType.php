<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\ContactType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom &/Où Entreprise'])
            ->add('message', CKEditorType::class, ['label' => 'Message'])
            ->add('phone', TelType::class, ['label' => 'Téléphone'])
            ->add('mail', EmailType::class, ['label' => 'Email'])
            ->add('contactType', EntityType::class, [
                'class' => ContactType::class,
                'label' => 'Pourquoi vous nous contactez ?'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
