<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EducativeSystemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;  
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Table(name: '`educative_systeme`')]
#[ORM\Entity(repositoryClass: EducativeSystemeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['educative_systeme:read']],
    denormalizationContext: ['groups' => ['educative_systeme:write']]
)]
class EducativeSysteme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['educative_systeme:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['educative_systeme:read', 'educative_systeme:write'])]
    private ?string $nameEduc = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['educative_systeme:read', 'educative_systeme:write'])]
    private ?string $descriptEduc = null;

    #[ORM\ManyToOne(inversedBy: 'educativeSystemes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['educative_systeme:read', 'educative_systeme:write'])]
    private ?User $user = null;

    /**
     * @var Collection<int, University>
     */
    #[ORM\ManyToMany(targetEntity: University::class, mappedBy: 'systeme')]
    #[Groups(['educative_systeme:read'])]
    private Collection $universities;

    /**
     * @var Collection<int, Promo>
     */
    #[ORM\OneToMany(targetEntity: Promo::class, mappedBy: 'systeme')]
    private Collection $promos;

    /**
     * @var Collection<int, Mention>
     */
    #[ORM\OneToMany(targetEntity: Mention::class, mappedBy: 'systeme')]
    private Collection $mentions;

    public function __construct()
    {
        $this->universities = new ArrayCollection();
        $this->promos = new ArrayCollection();
        $this->mentions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameEduc(): ?string
    {
        return $this->nameEduc;
    }

    public function setNameEduc(string $nameEduc): static
    {
        $this->nameEduc = $nameEduc;

        return $this;
    }

    public function getDescriptEduc(): ?string
    {
        return $this->descriptEduc;
    }

    public function setDescriptEduc(?string $descriptEduc): static
    {
        $this->descriptEduc = $descriptEduc;

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

    /**
     * @return Collection<int, University>
     */
    public function getUniversities(): Collection
    {
        return $this->universities;
    }

    public function addUniversity(University $university): static
    {
        if (!$this->universities->contains($university)) {
            $this->universities->add($university);
            $university->addSysteme($this);
        }

        return $this;
    }

    public function removeUniversity(University $university): static
    {
        if ($this->universities->removeElement($university)) {
            $university->removeSysteme($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Promo>
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): static
    {
        if (!$this->promos->contains($promo)) {
            $this->promos->add($promo);
            $promo->setSysteme($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): static
    {
        if ($this->promos->removeElement($promo)) {
            // set the owning side to null (unless already changed)
            if ($promo->getSysteme() === $this) {
                $promo->setSysteme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mention>
     */
    public function getMentions(): Collection
    {
        return $this->mentions;
    }

    public function addMention(Mention $mention): static
    {
        if (!$this->mentions->contains($mention)) {
            $this->mentions->add($mention);
            $mention->setSysteme($this);
        }

        return $this;
    }

    public function removeMention(Mention $mention): static
    {
        if ($this->mentions->removeElement($mention)) {
            // set the owning side to null (unless already changed)
            if ($mention->getSysteme() === $this) {
                $mention->setSysteme(null);
            }
        }

        return $this;
    }
}
