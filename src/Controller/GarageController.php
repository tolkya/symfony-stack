<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Form\GarageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GarageController extends AbstractController
{
    #[Route('/mon-garage', name: 'app_mon_garage')]
    #[IsGranted('ROLE_USER')]
    public function monGarage(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $garage = $user->getGarage();

        // Créer un garage si l'utilisateur n'en a pas
        if (!$garage) {
            $garage = new Garage();
            $garage->setNom('Mon Garage');
            $garage->setLieu('Non défini');
            $garage->setCodePostal(0);
            $garage->setProprietaire($user);
            $entityManager->persist($garage);
            $entityManager->flush();
        }

        return $this->render('garage/mon-garage.html.twig', [
            'garage' => $garage,
            'motos' => $garage->getMotos(),
        ]);
    }

    #[Route('/mon-garage/modifier', name: 'app_garage_edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $garage = $user->getGarage();

        if (!$garage) {
            $garage = new Garage();
            $garage->setProprietaire($user);
        }

        $form = $this->createForm(GarageType::class, $garage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($garage);
            $entityManager->flush();

            $this->addFlash('success', 'Votre garage a été mis à jour avec succès !');

            return $this->redirectToRoute('app_mon_garage');
        }

        return $this->render('garage/edit.html.twig', [
            'garage' => $garage,
            'garageForm' => $form,
        ]);
    }
}