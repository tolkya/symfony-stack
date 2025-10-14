<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\MotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MotoRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['moto:read']],
    denormalizationContext: ['groups' => ['moto:write']],
    paginationEnabled: true,
    paginationItemsPerPage: 20
)]
#[ApiFilter(SearchFilter::class, properties: [
    'marque.nom' => 'partial',
    'Modele' => 'partial', 
    'Categorie' => 'exact',
    'Couleur' => 'exact'
])]
#[ApiFilter(RangeFilter::class, properties: ['Annee', 'Cylindree', 'Chevaux'])]
#[ApiFilter(OrderFilter::class, properties: ['Annee', 'Cylindree', 'Chevaux', 'marque.nom'])]
class Moto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['moto:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Marque::class, inversedBy: 'motos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['moto:read', 'moto:write'])]
    private ?Marque $marque = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le modèle est obligatoire')]
    #[Groups(['moto:read', 'moto:write'])]
    private ?string $Modele = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['moto:read', 'moto:write'])]
    private ?string $Edition = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'La catégorie est obligatoire')]
    #[Groups(['moto:read', 'moto:write'])]
    private ?string $Categorie = null;

    #[ORM\Column]
    #[Assert\Range(min: 1900, max: 2030, notInRangeMessage: 'L\'année doit être entre {{ min }} et {{ max }}')]
    #[Groups(['moto:read', 'moto:write'])]
    private ?int $Annee = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'La couleur est obligatoire')]
    #[Groups(['moto:read', 'moto:write'])]
    private ?string $Couleur = null;

    #[ORM\Column]
    #[Assert\Range(min: 50, max: 3000, notInRangeMessage: 'La cylindrée doit être entre {{ min }}cc et {{ max }}cc')]
    #[Groups(['moto:read', 'moto:write'])]
    private ?int $Cylindree = null;

    #[ORM\Column]
    #[Assert\Range(min: 5, max: 450, notInRangeMessage: 'La puissance doit être entre {{ min }}ch et {{ max }}ch')]
    #[Groups(['moto:read', 'moto:write'])]
    private ?int $Chevaux = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: 'La description est obligatoire')]
    #[Groups(['moto:read', 'moto:write'])]
    private ?string $Description = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['moto:read', 'moto:write'])]
    private ?string $Utilite = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['moto:read', 'moto:write'])]
    private ?string $Image = null;

    #[ORM\ManyToOne(targetEntity: Garage::class, inversedBy: 'motos')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id')]
    #[Groups(['moto:read', 'moto:write'])]
    private ?Garage $garage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

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

    public function getGarage(): ?Garage
    {
        return $this->garage;
    }

    public function setGarage(?Garage $garage): static
    {
        $this->garage = $garage;

        return $this;
    }
}
