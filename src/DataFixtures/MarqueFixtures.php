<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class MarqueFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['marque'];
    }

    public function load(ObjectManager $manager): void
    {
        $marquesData = [
            ['nom' => 'Honda', 'pays' => 'Japon', 'annee' => 1948],
            ['nom' => 'Yamaha', 'pays' => 'Japon', 'annee' => 1955],
            ['nom' => 'Kawasaki', 'pays' => 'Japon', 'annee' => 1896],
            ['nom' => 'Suzuki', 'pays' => 'Japon', 'annee' => 1909],
            ['nom' => 'KTM', 'pays' => 'Autriche', 'annee' => 1934],
            ['nom' => 'BMW', 'pays' => 'Allemagne', 'annee' => 1916],
            ['nom' => 'Ducati', 'pays' => 'Italie', 'annee' => 1926],
            ['nom' => 'Aprilia', 'pays' => 'Italie', 'annee' => 1945],
            ['nom' => 'Triumph', 'pays' => 'Royaume-Uni', 'annee' => 1902],
            ['nom' => 'Harley-Davidson', 'pays' => 'États-Unis', 'annee' => 1903],
            // Ajoutez autant de marques que vous voulez...
        ];

        foreach ($marquesData as $data) {
            $marque = new Marque();
            $marque->setNom($data['nom']);
            $marque->setPays($data['pays']);
            $marque->setAnneCreation($data['annee']);
            
            $manager->persist($marque);
        }

        $manager->flush();
    }
}
