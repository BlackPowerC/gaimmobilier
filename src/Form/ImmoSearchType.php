<?php

namespace App\Form;

use App\Entity\ImmoSearch;
use App\Entity\Option;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('options', EntityType::class, [
                "required" => false,
                "label" => false,
                "class" => Option::class,
                "choice_label" => "name",
                "multiple" => true,
                "attr" => [
                    "placeholder" => "Les options"
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
