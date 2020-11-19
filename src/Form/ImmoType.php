<?php

namespace App\Form;

use App\Entity\Immo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('heat', ChoiceType::class, [
                "choices" => $this->getChoices()
            ])
            ->add('city')
            ->add('address')
            ->add('postalCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Immo::class,
            "translation_domain" => "form"
        ]);
    }

    private function getChoices()
    {
        $choices = [] ;
        foreach (Immo::HEAT as $choiceKey => $choiceValue) {
            $choices[$choiceValue] = $choiceKey;
        }
        return $choices ;
    }
}
