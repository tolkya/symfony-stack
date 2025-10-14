<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\MarqueRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Moto;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['marque:read']],
    denormalizationContext: ['groups' => ['marque:write']]
)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['marque:read', 'moto:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['marque:read', 'marque:write', 'moto:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['marque:read', 'marque:write'])]
    private ?string $pays = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['marque:read', 'marque:write'])]
    private ?int $anneCreation = null;

    /**
     * @var Collection<int, Moto>
     */
    #[ORM\OneToMany(targetEntity: Moto::class, mappedBy: 'marque')]
    #[Groups(['marque:read:full'])]
    private Collection $motos;

    public function __construct()
    {
        $this->motos = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getAnneCreation(): ?int
    {
        return $this->anneCreation;
    }

    public function setAnneCreation(?int $anneCreation): static
    {
        $this->anneCreation = $anneCreation;

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->nom ?? '';
    }
}
