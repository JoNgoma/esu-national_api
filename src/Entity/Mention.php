<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MentionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Table(name: '`mention`')]
#[ApiResource(
    normalizationContext: ['groups' => ['mention:read']],
    denormalizationContext: ['groups' => ['mention:write']]
)]

#[ORM\Entity(repositoryClass: MentionRepository::class)]
class Mention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['mention:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mention:read','mention:write'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'mentions')]
    private ?EducativeSysteme $systeme = null;

    /**
     * @var Collection<int, PromoMention>
     */
    #[ORM\ManyToMany(targetEntity: PromoMention::class, mappedBy: 'mention')]
    private Collection $promoMentions;

    #[ORM\OneToOne(mappedBy: 'mention', targetEntity: PromoMention::class)]
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
            $promoMention->addMention($this);
        }

        return $this;
    }

    public function removePromoMention(PromoMention $promoMention): static
    {
        if ($this->promoMentions->removeElement($promoMention)) {
            $promoMention->removeMention($this);
        }

        return $this;
    }

}
