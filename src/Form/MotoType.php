<?php

namespace App\Form;

use App\Entity\Moto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Marque', TextType::class, [
                'label' => 'Marque',
                'attr' => ['placeholder' => 'Honda, Yamaha, Kawasaki...']
            ])
            ->add('Modele', TextType::class, [
                'label' => 'Modèle',
                'attr' => ['placeholder' => 'CBR 1000 RR-R']
            ])
            ->add('Edition', TextType::class, [
                'label' => 'Édition',
                'required' => false,
                'attr' => ['placeholder' => 'Fireblade 100th TT Start Limited Edition']
            ])
            ->add('Categorie', ChoiceType::class, [
                'label' => 'Catégorie',
                'choices' => [
                    'Adventure' => 'Adventure',
                    'Cross' => 'Cross',
                    'Cruiser' => 'Cruiser',
                    'Enduro' => 'Enduro',
                    'Roadster' => 'Roadster',
                    'Routière' => 'Routiere',
                    'Sportive' => 'Sportive',
                    'Supermotard' => 'Supermotard',
                    'Trail' => 'Trail',
                ],
                'placeholder' => '-- Choisir une catégorie --'
            ])
            ->add('Annee', IntegerType::class, [
                'label' => 'Année',
                'attr' => [
                    'min' => 1900,
                    'max' => date('Y'),
                    'placeholder' => date('Y')
                ]
            ])
            ->add('Couleur', TextType::class, [
                'label' => 'Couleur',
                'attr' => ['placeholder' => 'Rouge, Noir, Blanc...']
            ])
            ->add('Cylindree', IntegerType::class, [
                'label' => 'Cylindrée (cc)',
                'attr' => [
                    'min' => 50,
                    'max' => 3000,
                    'placeholder' => '650'
                ]
            ])
            ->add('Chevaux', IntegerType::class, [
                'label' => 'Puissance (ch)',
                'attr' => [
                    'min' => 5,
                    'max' => 450,
                    'placeholder' => '95'
                ]
            ])
            ->add('Description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Décrivez votre moto...'
                ]
            ])
            ->add('Utilite', TextareaType::class, [
                'label' => 'Utilité',
                'required' => false,
                'attr' => [
                    'rows' => 3,
                    'placeholder' => 'Balade, sport, voyage...'
                ]
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image de la moto',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG, PNG, WebP)',
                    ])
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer la moto',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Moto::class,
        ]);
    }
}
