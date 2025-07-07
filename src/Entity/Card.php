<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Table(name: '`card`')]
#[ApiResource(
    normalizationContext: ['groups' => ['card:read']],
    denormalizationContext: ['groups' => ['card:write']]
)]
#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['card:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['card:read', 'card:write'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['card:read', 'card:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['card:read', 'card:write'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['card:read', 'card:write'])]
    private ?string $numDiplome = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['card:read', 'card:write'])]
    private ?string $scolastic = null;

    #[ORM\Column]
    #[Groups(['card:read', 'card:write'])]
    private ?bool $isMindInstitution = true;

    #[ORM\Column]
    #[Groups(['card:read', 'card:write'])]
    private ?bool $isMindController = true;

    #[ORM\Column]
    #[Groups(['card:read', 'card:write'])]
    private ?bool $isMindSecretariate = true;

    #[ORM\Column]
    #[Groups(['card:read', 'card:write'])]
    private ?bool $isMindCommission = true;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]
    #[Groups(['card:read', 'card:write'])]
    private ?User $user = null;

    /**
     * @var Collection<int, PromoMention>
     */
    #[ORM\OneToMany(targetEntity: PromoMention::class, mappedBy: 'card', cascade: ['persist'])]
    #[Groups(['card:read', 'card:write'])]
    private Collection $promoMentions;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['card:read', 'card:write'])]
    private ?Province $province = null;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['card:read', 'card:write'])]
    private ?University $university = null;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    #[Groups(['card:read', 'card:write'])]
    private ?Faculte $faculte = null;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    #[Groups(['card:read', 'card:write'])]
    private ?Domain $domain = null;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    #[Groups(['card:read', 'card:write'])]
    private ?Departement $departement = null;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    #[Groups(['card:read', 'card:write'])]
    private ?Spinneret $spinneret = null;

    public function __construct()
    {
        $this->promoMentions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNumDiplome(): ?string
    {
        return $this->numDiplome;
    }

    public function setNumDiplome(?string $numDiplome): static
    {
        $this->numDiplome = $numDiplome;

        return $this;
    }

    public function getScolastic(): ?string
    {
        return $this->scolastic;
    }

    public function setScolastic(?string $scolastic): static
    {
        $this->scolastic = $scolastic;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getProvince(): ?Province
    {
        return $this->province;
    }

    public function setProvince(?Province $province): static
    {
        $this->province = $province;

        return $this;
    }

    public function getUniversity(): ?University
    {
        return $this->university;
    }

    public function setUniversity(?University $university): static
    {
        $this->university = $university;

        return $this;
    }

    public function getFaculte(): ?Faculte
    {
        return $this->faculte;
    }

    public function setFaculte(?Faculte $faculte): static
    {
        $this->faculte = $faculte;

        return $this;
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getSpinneret(): ?Spinneret
    {
        return $this->spinneret;
    }

    public function setSpinneret(?Spinneret $spinneret): static
    {
        $this->spinneret = $spinneret;

        return $this;
    }

    /**
     * @return Collection<int, PromoMention>
     */
    public function getPromoMentions(): Collection
    {
        return $this->promoMentions;
    }

    public function addPromoMention(PromoMention $promoMention): static
    {
        if (!$this->promoMentions->contains($promoMention)) {
            $this->promoMentions->add($promoMention);
            $promoMention->setCard($this);
        }

        return $this;
    }

    public function removePromoMention(PromoMention $promoMention): static
    {
        if ($this->promoMentions->removeElement($promoMention)) {
            // set the owning side to null (unless already changed)
            if ($promoMention->getCard() === $this) {
                $promoMention->setCard(null);
            }
        }

        return $this;
    }

    // Add getters and setters for the new boolean fields
    public function getIsMindInstitution(): ?bool
    {
        return $this->isMindInstitution;
    }

    public function setIsMindInstitution(bool $isMindInstitution): static
    {
        $this->isMindInstitution = $isMindInstitution;
        return $this;
    }

    public function getIsMindController(): ?bool
    {
        return $this->isMindController;
    }

    public function setIsMindController(bool $isMindController): static
    {
        $this->isMindController = $isMindController;
        return $this;
    }

    public function getIsMindSecretariate(): ?bool
    {
        return $this->isMindSecretariate;
    }

    public function setIsMindSecretariate(bool $isMindSecretariate): static
    {
        $this->isMindSecretariate = $isMindSecretariate;
        return $this;
    }

    public function getIsMindCommission(): ?bool
    {
        return $this->isMindCommission;
    }

    public function setIsMindCommission(bool $isMindCommission): static
    {
        $this->isMindCommission = $isMindCommission;
        return $this;
    }

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['card:read', 'card:write'])]
    private ?string $matricule = null;

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;
        return $this;
    }
}
