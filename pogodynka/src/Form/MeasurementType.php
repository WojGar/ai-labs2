<?php

namespace App\Form;

use App\Entity\Measurement;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
                'label' => 'Location'
            ])
            ->add('measurement_date', DateType::class, [
                'label' => 'Measurement date',
                'widget' => 'single_text'
            ])
            ->add('temperature', NumberType::class, [
                'label' => 'Temperature (°C)',
                'attr' => ['placeholder' => 'e.g. 22']
            ])
            ->add('humidity', NumberType::class, [
                'label' => 'Humidity (%)',
                'attr' => ['placeholder' => 'e.g. 55']
            ])
            ->add('pressure', NumberType::class, [
                'label' => 'Pressure (hPa)',
                'attr' => ['placeholder' => 'e.g. 1013']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
            'validation_groups' => fn(FormInterface $form) =>
            $form->getData()->getId() ? ['edit'] : ['new'],
        ]);
    }
}
