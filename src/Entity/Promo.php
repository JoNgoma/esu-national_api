<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Table(name: 'promo')]
#[ApiResource
(
    normalizationContext: ['groups' => ['promo:read']],
    denormalizationContext: ['groups' => ['promo:write']]
)
]
#[ORM\Entity(repositoryClass: PromoRepository::class)]
class Promo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['promo:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['promo:read','promo:write'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'promos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['promo:read','promo:write'])]
    private ?EducativeSysteme $systeme = null;

    /**
     * @var Collection<int, Card>
     */
    #[ORM\ManyToMany(targetEntity: Card::class, mappedBy: 'promo')]
    private Collection $cards;

    /**
     * @var Collection<int, PromoMention>
     */
    #[ORM\ManyToMany(targetEntity: PromoMention::class, mappedBy: 'promo')]
    private Collection $promoMentions;

    #[ORM\OneToOne(mappedBy: 'promo', targetEntity: PromoMention::class)]
    private ?PromoMention $promoMention = null;

    public function getPromoMention(): ?PromoMention
    {
        return $this->promoMention;
    }

    public function setPromoMention(?PromoMention $promoMention): static
    {
        $this->promoMention = $promoMention;
        return $this;
    }

    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->promoMentions = new ArrayCollection();
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

    public function getSysteme(): ?EducativeSysteme
    {
        return $this->systeme;
    }

    public function setSysteme(?EducativeSysteme $systeme): static
    {
        $this->systeme = $systeme;

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
            $card->addPromo($this);
        }

        return $this;
    }

    public function removeCard(Card $card): static
    {
        if ($this->cards->removeElement($card)) {
            $card->removePromo($this);
        }

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
            $promoMention->addPromo($this);
        }

        return $this;
    }

    public function removePromoMention(PromoMention $promoMention): static
    {
        if ($this->promoMentions->removeElement($promoMention)) {
            $promoMention->removePromo($this);
        }

        return $this;
    }
}
