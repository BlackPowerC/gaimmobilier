<?php

namespace App\Form;

use App\Entity\ImmoSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImmoSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, [
                "required" => false,
                "label" => false,
                "attr" => [
                    "placeholder" => "Prix maximum",
                    "min" => "0"

                ]
            ])
            ->add('minSurface', IntegerType::class, [
                "required" => false,
                "label" => false,
                "attr" => [
                    "placeholder" => "Surface Minimale",
                    "min" => "0"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => ImmoSearch::class,
            "method" => "GET",
            "csrf_protection" => false
        ]);
    }

    public function getBlockPrefix() {
        return '' ;
    }
}
