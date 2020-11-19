<?php

namespace App\Form;

use App\Entity\Immo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImmoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('rooms')
            ->add('description')
            ->add('bedrooms')
            ->add('surface')
            ->add('floor')
            ->add('price')
            ->add('heat')
            ->add('city')
            ->add('address')
            ->add('postalCode')
            ->add('sold')
            ->add('addedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Immo::class,
        ]);
    }
}
