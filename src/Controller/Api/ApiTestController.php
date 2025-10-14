<?php

namespace App\Controller\Api;

use App\Entity\Moto;
use App\Repository\MotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/test', name: 'api_test_')]
class ApiTestController extends AbstractController
{
    #[Route('/motos', name: 'motos', methods: ['GET'])]
    public function getMotos(MotoRepository $motoRepository): JsonResponse
    {
        $motos = $motoRepository->findAll();
        
        $data = [];
        foreach ($motos as $moto) {
            $data[] = [
                'id' => $moto->getId(),
                'modele' => $moto->getModele(),
                'marque' => $moto->getMarque() ? $moto->getMarque()->getNom() : null,
                'categorie' => $moto->getCategorie(),
                'annee' => $moto->getAnnee(),
                'cylindree' => $moto->getCylindree(),
                'chevaux' => $moto->getChevaux(),
                'couleur' => $moto->getCouleur()
            ];
        }

        return $this->json([
            'message' => 'API Moto fonctionnelle !',
            'count' => count($motos),
            'motos' => $data
        ]);
    }

    #[Route('/status', name: 'status', methods: ['GET'])]
    public function status(): JsonResponse
    {
        return $this->json([
            'status' => 'OK',
            'message' => 'L\'API est en fonctionnement !',
            'timestamp' => new \DateTime(),
            'endpoints' => [
                'GET /api/motos' => 'Récupère toutes les motos',
                'GET /api/motos/{id}' => 'Récupère une moto par ID',
                'POST /api/motos' => 'Crée une nouvelle moto',
                'PUT /api/motos/{id}' => 'Met à jour une moto',
                'DELETE /api/motos/{id}' => 'Supprime une moto'
            ],
            'swagger_ui' => '/api/docs'
        ], 200, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type'
        ]);
    }

    #[Route('/debug', name: 'debug', methods: ['GET'])]
    public function debug(MotoRepository $motoRepository): JsonResponse
    {
        try {
            $motos = $motoRepository->findAll();
            return $this->json([
                'message' => 'Debug API - Tout fonctionne',
                'total_motos' => count($motos),
                'first_moto' => $motos[0] ?? null ? [
                    'id' => $motos[0]->getId(),
                    'modele' => $motos[0]->getModele(),
                    'marque' => $motos[0]->getMarque()?->getNom()
                ] : null
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Erreur lors de la récupération des motos',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}