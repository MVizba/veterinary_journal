<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                    'Other' => 'other',
                ],
                'placeholder' => 'Choose a gender',
                'expanded' => false,
                'required' => true,
            ])
            ->add('age')
//                IntegerType::class, [
//                'constraints' => [
//                    new Assert\NotBlank([
//                        'message' => 'This field is required',
//                    ]),
//                    new Assert\Positive([
//                        'message' => 'Please enter a valid age',
//                    ]),
//                ],
//                'attr' => [
//                    'class' => 'form-control',
//                    'placeholder' => 'Enter Age',
//                ]
//            ])
            ->add('markingNumber')
            ->add('passportNumber')
            ->add('appearance')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => function (Client $client) {
                    return $client->getName() . ' ' . $client->getLastName();
                },
                'placeholder' => 'Choose an owner',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
