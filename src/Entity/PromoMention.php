<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PromoMentionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Table(name: 'promo_mention')]
#[ApiResource
(
    normalizationContext: ['groups' => ['promo_mention:read']],
    denormalizationContext: ['groups' => ['promo_mention:write']]
)
]
#[ORM\Entity(repositoryClass: PromoMentionRepository::class)]
class PromoMention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['promo_mention:read'])]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Promo::class, inversedBy: 'promoMention')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['card:read', 'card:write'])]
    private ?Promo $promo = null;

    #[ORM\OneToOne(targetEntity: Mention::class, inversedBy: 'promoMention')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['card:read', 'card:write'])]
    private ?Mention $mention = null;

    #[ORM\ManyToOne(inversedBy: 'promoMentions')]
    private ?Card $card = null;

    #[ORM\Column(length: 11)]
    #[Groups(['card:read', 'card:write'])]
    private ?string $academicYear = null;

    public function __construct()
    {
        // Empty constructor - no initialization needed for OneToOne relationships
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): static
    {
        $this->promo = $promo;
        return $this;
    }

    public function getMention(): ?Mention
    {
        return $this->mention;
    }

    public function setMention(?Mention $mention): static
    {
        $this->mention = $mention;
        return $this;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): static
    {
        $this->card = $card;

        return $this;
    }

    public function getAcademicYear(): ?string
    {
        return $this->academicYear;
    }

    public function setAcademicYear(string $academicYear): static
    {
        $this->academicYear = $academicYear;
        return $this;
    }
}
