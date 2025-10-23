<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'City name',
                'attr' => ['placeholder' => 'e.g. Warsaw']
            ])
            ->add('country', CountryType::class, [
                'label' => 'Country (2-letter code)',
                'placeholder' => 'Select a country'
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Latitude',
                'scale' => 7
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Longitude',
                'scale' => 7
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
            // Dynamic validation groups
            'validation_groups' => fn(FormInterface $form) =>
            $form->getData()->getId() ? ['edit'] : ['new'],
        ]);
    }
}
