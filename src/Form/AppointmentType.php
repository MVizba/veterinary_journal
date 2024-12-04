<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\Client;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'name',
                'placeholder' => 'Select Client',
            ])
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => 'name',
                'placeholder' => 'Select Patient',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('registrationDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('symptomDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('status', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('diagnosis', TextareaType::class, [
                'required' => false,
            ])
            ->add('services', TextareaType::class, [
                'required' => false,
            ])
            ->add('endResult', TextareaType::class, [
                'required' => false,
            ])
            ->add('examinations', CollectionType::class, [
                'entry_type' => AppointmentExaminationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
            ])
            ->add('drugs', CollectionType::class, [
                'entry_type' => AppointmentDrugType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}