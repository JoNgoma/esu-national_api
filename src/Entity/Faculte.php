<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FaculteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;  
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Table(name: 'faculte')]
#[ORM\Entity(repositoryClass: FaculteRepository::class)]

#[ApiResource(
    normalizationContext: ['groups'=> ['faculte:read']],
    denormalizationContext: ['groups' => ['faculte:write']] 
)]
class Faculte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['faculte:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['university:read', 'faculte:read', 'faculte:write'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['faculte:read', 'faculte:write'])]
    private ?string $description = null;

    /**
     * @var Collection<int, University>
     */
    #[ORM\ManyToMany(targetEntity: University::class, inversedBy: 'facultes')]
    #[Groups(['faculte:read', 'faculte:write'])]
    private Collection $university;

    /**
     * @var Collection<int, Departement>
     */
    #[ORM\OneToMany(targetEntity: Departement::class, mappedBy: 'faculte', orphanRemoval: true)]
    private Collection $departements;

    /**
     * @var Collection<int, Card>
     */
    #[ORM\OneToMany(targetEntity: Card::class, mappedBy: 'faculte')]
    private Collection $cards;

    public function __construct()
    {
        $this->university = new ArrayCollection();
        $this->departements = new ArrayCollection();
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, University>
     */
    public function getUniversity(): Collection
    {
        return $this->university;
    }

    public function addUniversity(University $university): static
    {
        if (!$this->university->contains($university)) {
            $this->university->add($university);
        }

        return $this;
    }

    public function removeUniversity(University $university): static
    {
        $this->university->removeElement($university);

        return $this;
    }

    /**
     * @return Collection<int, Departement>
     */
    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(Departement $departement): static
    {
        if (!$this->departements->contains($departement)) {
            $this->departements->add($departement);
            $departement->setFaculte($this);
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): static
    {
        if ($this->departements->removeElement($departement)) {
            // set the owning side to null (unless already changed)
            if ($departement->getFaculte() === $this) {
                $departement->setFaculte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): static
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
            $card->setFaculte($this);
        }

        return $this;
    }

    public function removeCard(Card $card): static
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getFaculte() === $this) {
                $card->setFaculte(null);
            }
        }

        return $this;
    }
}
