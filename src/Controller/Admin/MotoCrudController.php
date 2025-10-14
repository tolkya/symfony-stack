<?php

namespace App\Controller\Admin;

use App\Entity\Moto;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class MotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Moto::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Moto')
            ->setEntityLabelInPlural('Motos')
            ->setPageTitle('index', 'Gestion des Motos')
            ->setPageTitle('new', 'Créer une Moto')
            ->setPageTitle('edit', 'Modifier une Moto')
            ->setPageTitle('detail', 'Détails de la Moto')
            ->setDefaultSort(['id' => 'DESC'])
            ->setPaginatorPageSize(15);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->setLabel('Nouvelle moto');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            
            AssociationField::new('marque', 'Marque')
                ->setRequired(true)
                ->setHelp('Sélectionner la marque de la moto'),
                
            TextField::new('Modele', 'Modèle')
                ->setRequired(true)
                ->setHelp('Modèle de la moto'),
                
            TextField::new('Edition', 'Édition')
                ->setHelp('Édition spéciale (optionnel)'),
                
            ChoiceField::new('Categorie', 'Catégorie')
                ->setChoices([
                    'Sportive' => 'sportive',
                    'Roadster' => 'roadster', 
                    'Cruiser' => 'cruiser',
                    'Trail' => 'trail',
                    'Scooter' => 'scooter',
                    'Custom' => 'custom',
                    'Touring' => 'touring'
                ])
                ->setRequired(true),
                
            IntegerField::new('Annee', 'Année')
                ->setHelp('Année de fabrication (1900-2030)'),
                
            TextField::new('Couleur', 'Couleur')
                ->setRequired(true),
                
            IntegerField::new('Cylindree', 'Cylindrée (cc)')
                ->setHelp('Cylindrée en centimètres cubes (50-3000)'),
                
            IntegerField::new('Chevaux', 'Puissance (ch)')
                ->setHelp('Puissance en chevaux (5-450)'),
                
            TextareaField::new('Description', 'Description')
                ->setHelp('Description détaillée de la moto')
                ->hideOnIndex(),
                
            TextareaField::new('Utilite', 'Utilité')
                ->setHelp('Usage prévu de la moto (optionnel)')
                ->hideOnIndex(),
                
            ImageField::new('Image', 'Photo')
                ->setBasePath('/uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setHelp('Image de la moto (optionnel)')
                ->hideOnIndex(),
                
            AssociationField::new('garage', 'Garage')
                ->setHelp('Garage où se trouve la moto (optionnel)')
        ];
    }
}