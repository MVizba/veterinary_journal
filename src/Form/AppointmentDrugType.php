<?php

namespace App\Form;

use App\Entity\AppointmentDrug;
use App\Entity\Drug;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentDrugType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('drug', EntityType::class, [
                'class' => Drug::class,
                'choice_label' => 'name',
            ])
            ->add('amount', IntegerType::class, [
                'attr' => ['min' => 1],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AppointmentDrug::class,
        ]);
    }
}