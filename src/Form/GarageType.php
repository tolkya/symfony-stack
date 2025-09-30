<?php

namespace App\Form;

use App\Entity\Garage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class GarageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'label' => 'Nom du garage',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Mon garage personnel'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le nom du garage est obligatoire']),
                    new Length(['max' => 255])
                ]
            ])
            ->add('Lieu', TextType::class, [
                'label' => 'Lieu/Adresse',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 123 rue de la Paix, Paris'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le lieu est obligatoire']),
                    new Length(['max' => 255])
                ]
            ])
            ->add('CodePostal', IntegerType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 75001'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le code postal est obligatoire']),
                    new Positive(['message' => 'Le code postal doit être positif'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Garage::class,
        ]);
    }
}