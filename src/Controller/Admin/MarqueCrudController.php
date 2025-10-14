<?php

namespace App\Controller\Admin;

use App\Entity\Marque;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class MarqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Marque::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Marque')
            ->setEntityLabelInPlural('Marques')
            ->setPageTitle('index', 'Gestion des Marques')
            ->setPageTitle('new', 'Créer une Marque')
            ->setPageTitle('edit', 'Modifier une Marque')
            ->setPageTitle('detail', 'Détails de la Marque')
            ->setDefaultSort(['nom' => 'ASC'])
            ->setPaginatorPageSize(20);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->setLabel('Nouvelle marque');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            
            TextField::new('nom', 'Nom de la marque')
                ->setRequired(true)
                ->setHelp('Nom de la marque de moto'),
                
            TextField::new('pays', 'Pays d\'origine')
                ->setHelp('Pays d\'origine de la marque (optionnel)'),
                
            IntegerField::new('anneCreation', 'Année de création')
                ->setHelp('Année de création de la marque (optionnel)'),
                
            AssociationField::new('motos', 'Motos associées')
                ->hideOnForm()
                ->setHelp('Liste des motos de cette marque')
        ];
    }
}