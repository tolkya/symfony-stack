<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setPageTitle('index', 'Gestion des Utilisateurs')
            ->setPageTitle('new', 'Créer un Utilisateur')
            ->setPageTitle('edit', 'Modifier un Utilisateur')
            ->setPageTitle('detail', 'Détails de l\'Utilisateur')
            ->setDefaultSort(['id' => 'DESC'])
            ->setPaginatorPageSize(20);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->setLabel('Nouvel utilisateur');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email', 'Email')
                ->setRequired(true)
                ->setHelp('Adresse email unique de l\'utilisateur'),
        ];

        // Champ mot de passe seulement lors de la création ou modification
        if ($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT) {
            $fields[] = TextField::new('plainPassword', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->setHelp($pageName === Crud::PAGE_NEW ? 'Mot de passe requis' : 'Laisser vide pour ne pas changer')
                ->onlyOnForms();
        }

        $fields[] = ChoiceField::new('roles', 'Rôles')
            ->setChoices([
                'Utilisateur' => 'ROLE_USER',
                'Administrateur' => 'ROLE_ADMIN',
                'Super Admin' => 'ROLE_SUPER_ADMIN'
            ])
            ->allowMultipleChoices()
            ->setHelp('Sélectionner les rôles de l\'utilisateur')
            ->renderExpanded(false)
            ->renderAsBadges([
                'ROLE_USER' => 'success',
                'ROLE_ADMIN' => 'warning', 
                'ROLE_SUPER_ADMIN' => 'danger'
            ]);

        $fields[] = AssociationField::new('garage', 'Garage')
            ->setHelp('Garage associé à cet utilisateur (optionnel)');

        return $fields;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $user */
        $user = $entityInstance;
        
        // Hasher le mot de passe si fourni
        if ($user->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($hashedPassword);
        }

        $entityManager->persist($user);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $user */
        $user = $entityInstance;
        
        // Hasher le nouveau mot de passe si fourni
        if ($user->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($hashedPassword);
        }

        $entityManager->persist($user);
        $entityManager->flush();
    }
}
