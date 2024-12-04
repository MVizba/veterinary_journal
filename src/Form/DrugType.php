<?php

namespace App\Form;

use App\Entity\Drug;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrugType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Drug Name',
            ])
            ->add('dateOfReceipt', null, [
                'widget' => 'single_text',
                'label' => 'Date of Receipt',
            ])
            ->add('documentName', null, [
                'label' => 'Document Name',
            ])
            ->add('amount', null, [
                'label' => 'Amount',
            ])
            ->add('manufactureDate', null, [
                'widget' => 'single_text',
                'label' => 'Manufacture Date',
            ])
            ->add('expirationDate', null, [
                'widget' => 'single_text',
                'label' => 'Expiration Date',
            ])
            ->add('series', null, [
                'label' => 'Series',
            ])
            ->add('whereObtainedFrom', null, [
                'label' => 'Source',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Drug::class,
        ]);
    }
}
