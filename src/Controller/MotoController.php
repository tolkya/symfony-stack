<?php

namespace App\Controller;

use App\Entity\Moto;
use App\Form\MotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MotoController extends AbstractController
{
    #[Route('/moto/new', name: 'app_moto_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $moto = new Moto();
        $form = $this->createForm(MotoType::class, $moto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'upload d'image
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'), // Vous devrez configurer ce paramètre
                        $newFilename
                    );
                    $moto->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image');
                }
            }

            $entityManager->persist($moto);
            $entityManager->flush();

            $this->addFlash('success', 'Votre moto a été ajoutée avec succès !');

            return $this->redirectToRoute('app_moto_list');
        }

        return $this->render('moto/new.html.twig', [
            'motoForm' => $form,
        ]);
    }

    #[Route('/moto', name: 'app_moto_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $motos = $entityManager->getRepository(Moto::class)->findAll();

        return $this->render('moto/list.html.twig', [
            'motos' => $motos,
        ]);
    }

    #[Route('/moto/{id}', name: 'app_moto_show', requirements: ['id' => '\d+'])]
    public function show(Moto $moto): Response
    {
        return $this->render('moto/show.html.twig', [
            'moto' => $moto,
        ]);
    }

    #[Route('/moto/{id}/edit', name: 'app_moto_edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, Moto $moto, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(MotoType::class, $moto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'upload d'image
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                    $moto->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image');
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Votre moto a été modifiée avec succès !');

            return $this->redirectToRoute('app_moto_show', ['id' => $moto->getId()]);
        }

        return $this->render('moto/edit.html.twig', [
            'moto' => $moto,
            'motoForm' => $form,
        ]);
    }
}