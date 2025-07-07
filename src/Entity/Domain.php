<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Table(name:'domain')]
#[ORM\UniqueConstraint(name: 'UNIQ_DOMAIN_NAME', fields: ['name'])]
#[ApiResource(
    normalizationContext: ['groups' => ['domain:read']],
    denormalizationContext: ['groups' => ['domain:write']]
)]
#[ORM\Entity(repositoryClass: DomainRepository::class)]
class Domain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['domain:read'])]

    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['spinneret:read', 'university:read', 'domain:read', 'domain:write'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['domain:read', 'domain:write'])]
    private ?string $description = null;

    /**
     * @var Collection<int, University>
     */
    #[ORM\ManyToMany(targetEntity: University::class, inversedBy: 'domains')]
    #[Groups(['domain:read', 'domain:write'])]
    private Collection $university;

    /**
     * @var Collection<int, Spinneret>
     */
    #[ORM\OneToMany(targetEntity: Spinneret::class, mappedBy: 'domain', orphanRemoval: true)]
    private Collection $spinnerets;

    /**
     * @var Collection<int, Card>
     */
    #[ORM\OneToMany(targetEntity: Card::class, mappedBy: 'domain')]
    private Collection $cards;

    public function __construct()
    {
        $this->university = new ArrayCollection();
        $this->spinnerets = new ArrayCollection();
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
     * @return Collection<int, Spinneret>
     */
    public function getSpinnerets(): Collection
    {
        return $this->spinnerets;
    }

    public function addSpinneret(Spinneret $spinneret): static
    {
        if (!$this->spinnerets->contains($spinneret)) {
            $this->spinnerets->add($spinneret);
            $spinneret->setDomain($this);
        }

        return $this;
    }

    public function removeSpinneret(Spinneret $spinneret): static
    {
        if ($this->spinnerets->removeElement($spinneret)) {
            // set the owning side to null (unless already changed)
            if ($spinneret->getDomain() === $this) {
                $spinneret->setDomain(null);
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
            $card->setDomain($this);
        }

        return $this;
    }

    public function removeCard(Card $card): static
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getDomain() === $this) {
                $card->setDomain(null);
            }
        }

        return $this;
    }
}
