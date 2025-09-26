<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Créer vos variables
        $message = "Bienvenue sur votre application Symfony !";
        $nom = "Développeur";
        $date = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $technologies = ['Docker', 'Symfony', 'PostgreSQL', 'Twig'];
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'message' => $message,
            'nom' => $nom,
            'date' => $date,
            'technologies' => $technologies,
        ]);
    }
}
