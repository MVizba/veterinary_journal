<?php

namespace App\Form;

use App\Entity\Drug;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrugType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateOfReceipt', null, [
                'widget' => 'single_text',
            ])
            ->add('documentName')
            ->add('amount')
            ->add('manufactureDate', null, [
                'widget' => 'single_text',
            ])
            ->add('expirationDate', null, [
                'widget' => 'single_text',
            ])
            ->add('series')
            ->add('whereObtainedFrom')
            ->add('patients', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Drug::class,
        ]);
    }
}
