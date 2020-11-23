<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                "required" => false,
                "label" => "Nom"
            ])
            ->add('firstname', TextType::class, [
                "required" => false,
                "label" => "Prénom"
            ])
            ->add('email', TextType::class, [
                "required" => true,
                "label" => "Message"
             ])
            ->add('message', TextType::class, [
                "required" => true,
                "label" => "Message"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
