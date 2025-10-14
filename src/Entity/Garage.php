<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\GarageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GarageRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['garage:read']],
    denormalizationContext: ['groups' => ['garage:write']]
)]
class Garage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['garage:read', 'moto:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['garage:read', 'garage:write', 'moto:read'])]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['garage:read', 'garage:write'])]
    private ?string $Lieu = null;

    #[ORM\Column]
    #[Groups(['garage:read', 'garage:write'])]
    private ?int $CodePostal = null;

    #[ORM\OneToOne(inversedBy: 'garage')]
    #[ORM\JoinColumn(name: 'proprietaire_id', referencedColumnName: 'id')]
    #[Groups(['garage:read:full'])]
    private ?User $proprietaire = null;

    /**
     * @var Collection<int, Moto>
     */
    #[ORM\OneToMany(targetEntity: Moto::class, mappedBy: 'garage', cascade: ['persist', 'remove'])]
    #[Groups(['garage:read:full'])]
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
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(string $Lieu): static
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->CodePostal;
    }

    public function setCodePostal(int $CodePostal): static
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    /**
     * @return Collection<int, Moto>
     */
    public function getMotos(): Collection
    {
        return $this->motos;
    }

    public function getProprietaire(): ?User
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?User $proprietaire): static
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function addMoto(Moto $moto): static
    {
        if (!$this->motos->contains($moto)) {
            $this->motos->add($moto);
            $moto->setGarage($this);
        }

        return $this;
    }

    public function removeMoto(Moto $moto): static
    {
        if ($this->motos->removeElement($moto)) {
            // set the owning side to null (unless already changed)
            if ($moto->getGarage() === $this) {
                $moto->setGarage(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getNom() ?? 'Garage';
    }
}
