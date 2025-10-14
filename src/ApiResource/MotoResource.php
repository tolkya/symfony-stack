<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

/**
 * Configuration API avancée pour l'entité Moto
 * Cette classe permet de personnaliser les endpoints sans modifier l'entité
 */
class MotoApiConfiguration
{
    public static function getConfiguration(): array
    {
        return [
            'operations' => [
                new GetCollection(
                    uriTemplate: '/motos',
                    description: 'Récupère la collection de toutes les motos'
                ),
                new Get(
                    uriTemplate: '/motos/{id}',
                    description: 'Récupère une moto par son ID'
                ),
                new Post(
                    uriTemplate: '/motos',
                    description: 'Crée une nouvelle moto'
                ),
                new Put(
                    uriTemplate: '/motos/{id}',
                    description: 'Met à jour une moto existante'
                ),
                new Delete(
                    uriTemplate: '/motos/{id}',
                    description: 'Supprime une moto'
                )
            ],
            'filters' => [
                SearchFilter::class => [
                    'marque.nom' => 'partial',
                    'Modele' => 'partial',
                    'Categorie' => 'exact',
                    'Couleur' => 'exact'
                ],
                RangeFilter::class => [
                    'Annee',
                    'Cylindree', 
                    'Chevaux'
                ],
                OrderFilter::class => [
                    'Annee',
                    'Cylindree',
                    'Chevaux',
                    'marque.nom'
                ]
            ]
        ];
    }
}