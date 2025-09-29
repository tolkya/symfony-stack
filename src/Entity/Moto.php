<?php

namespace App\Entity;

use App\Repository\MotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MotoRepository::class)]
class Moto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La marque est obligatoire')]
    private ?string $Marque = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le modèle est obligatoire')]
    private ?string $Modele = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Edition = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'La catégorie est obligatoire')]
    private ?string $Categorie = null;

    #[ORM\Column]
    #[Assert\Range(min: 1900, max: 2030, notInRangeMessage: 'L\'année doit être entre {{ min }} et {{ max }}')]
    private ?int $Annee = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'La couleur est obligatoire')]
    private ?string $Couleur = null;

    #[ORM\Column]
    #[Assert\Range(min: 50, max: 3000, notInRangeMessage: 'La cylindrée doit être entre {{ min }}cc et {{ max }}cc')]
    private ?int $Cylindree = null;

    #[ORM\Column]
    #[Assert\Range(min: 5, max: 450, notInRangeMessage: 'La puissance doit être entre {{ min }}ch et {{ max }}ch')]
    private ?int $Chevaux = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: 'La description est obligatoire')]
    private ?string $Description = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $Utilite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->Marque;
    }

    public function setMarque(string $Marque): static
    {
        $this->Marque = $Marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->Modele;
    }

    public function setModele(string $Modele): static
    {
        $this->Modele = $Modele;

        return $this;
    }

    public function getEdition(): ?string
    {
        return $this->Edition;
    }

    public function setEdition(?string $Edition): static
    {
        $this->Edition = $Edition;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->Categorie;
    }

    public function setCategorie(string $Categorie): static
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->Annee;
    }

    public function setAnnee(int $Annee): static
    {
        $this->Annee = $Annee;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->Couleur;
    }

    public function setCouleur(string $Couleur): static
    {
        $this->Couleur = $Couleur;

        return $this;
    }

    public function getCylindree(): ?int
    {
        return $this->Cylindree;
    }

    public function setCylindree(int $Cylindree): static
    {
        $this->Cylindree = $Cylindree;

        return $this;
    }

    public function getChevaux(): ?int
    {
        return $this->Chevaux;
    }

    public function setChevaux(int $Chevaux): static
    {
        $this->Chevaux = $Chevaux;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getUtilite(): ?string
    {
        return $this->Utilite;
    }

    public function setUtilite(?string $Utilite): static
    {
        $this->Utilite = $Utilite;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }
}
