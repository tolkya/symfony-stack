<?php

namespace App\Controller\Admin;

use App\Entity\Garage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class GarageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Garage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Garage')
            ->setEntityLabelInPlural('Garages')
            ->setPageTitle('index', 'Gestion des Garages')
            ->setPageTitle('new', 'Créer un Garage')
            ->setPageTitle('edit', 'Modifier un Garage')
            ->setPageTitle('detail', 'Détails du Garage')
            ->setDefaultSort(['Nom' => 'ASC'])
            ->setPaginatorPageSize(20);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->setLabel('Nouveau garage');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            
            TextField::new('Nom', 'Nom du garage')
                ->setRequired(true)
                ->setHelp('Nom du garage'),
                
            TextField::new('Lieu', 'Localisation')
                ->setRequired(true)
                ->setHelp('Ville ou adresse du garage'),
                
            IntegerField::new('CodePostal', 'Code postal')
                ->setRequired(true)
                ->setHelp('Code postal du garage'),
                
            AssociationField::new('proprietaire', 'Propriétaire')
                ->setHelp('Utilisateur propriétaire de ce garage'),
                
            AssociationField::new('motos', 'Motos dans ce garage')
                ->hideOnForm()
                ->setHelp('Liste des motos stockées dans ce garage')
        ];
    }
}