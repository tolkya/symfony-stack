<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ParkController extends AbstractController
{
    #[Route('/park', name: 'app_park')]
    public function index(): Response
    {
        return $this->render('park/index.html.twig', [
            'controller_name' => 'ParkController',
        ]);
    }
}
