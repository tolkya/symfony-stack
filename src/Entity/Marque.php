<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Moto;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $pays = null;

    #[ORM\Column(nullable: true)]
    private ?int $anneCreation = null;

    /**
     * @var Collection<int, Moto>
     */
    #[ORM\OneToMany(targetEntity: Moto::class, mappedBy: 'marque')]
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
