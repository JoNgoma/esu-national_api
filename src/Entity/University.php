<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UniversityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;  
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Table(name: '`university`')]
#[ORM\UniqueConstraint(name: 'UNIQ_UNIVERSITY_NAME', fields: ['name'])]
#[ORM\UniqueConstraint(name: 'UNIQ_UNIVERSITY_POSTOFFICEBOX', fields: ['postOfficeBox'])]
#[ORM\UniqueConstraint(name: 'UNIQ_UNIVERSITY_PHONE', fields: ['phone'])]
#[ApiResource(
    normalizationContext: ['groups' => ['university:read']],
    denormalizationContext: ['groups' => ['university:write']]
)]

#[ORM\Entity(repositoryClass: UniversityRepository::class)]
class University
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['university:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['domain:read', 'faculte:read', 'province:read', 'educative_systeme:read', 'university:read', 'university:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]
    #[Groups(['university:read', 'university:write'])]
    private ?string $postOfficeBox = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['university:read', 'university:write'])]
    private ?string $adress = null;

    #[ORM\Column(length: 16, unique: true)]
    #[Groups(['university:read', 'university:write'])]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'universities')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['university:read', 'university:write'])]
    private ?User $user = null;

    /**
     * @var Collection<int, EducativeSysteme>
     */
    #[ORM\ManyToMany(targetEntity: EducativeSysteme::class, inversedBy: 'universities')]
    #[groups(['university:write'])]
    private Collection $systeme;

    #[ORM\ManyToOne(inversedBy: 'universities')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['domain:read', 'faculte:read', 'university:write', 'university:read'])]
    private ?Province $province = null;

    /**
     * @var Collection<int, Faculte>
     */
    #[ORM\ManyToMany(targetEntity: Faculte::class, mappedBy: 'university')]
    #[groups(['university:read'])]
    private Collection $facultes;

    /**
     * @var Collection<int, Domain>
     */
    #[ORM\ManyToMany(targetEntity: Domain::class, mappedBy: 'university')]
    #[groups(['university:read'])]
    private Collection $domains;

    /**
     * @var Collection<int, Card>
     */
    #[ORM\OneToMany(targetEntity: Card::class, mappedBy: 'university')]
    private Collection $cards;

    public function __construct()
    {
        $this->systeme = new ArrayCollection();
        $this->facultes = new ArrayCollection();
        $this->domains = new ArrayCollection();
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

    public function getPostOfficeBox(): ?string
    {
        return $this->postOfficeBox;
    }

    public function setPostOfficeBox(?string $postOfficeBox): static
    {
        $this->postOfficeBox = $postOfficeBox;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

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
     * @return Collection<int, EducativeSysteme>
     */
    public function getSysteme(): Collection
    {
        return $this->systeme;
    }

    public function addSysteme(EducativeSysteme $systeme): static
    {
        if (!$this->systeme->contains($systeme)) {
            $this->systeme->add($systeme);
        }

        return $this;
    }

    public function removeSysteme(EducativeSysteme $systeme): static
    {
        $this->systeme->removeElement($systeme);

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

    /**
     * @return Collection<int, Faculte>
     */
    public function getFacultes(): Collection
    {
        return $this->facultes;
    }

    public function addFaculte(Faculte $faculte): static
    {
        if (!$this->facultes->contains($faculte)) {
            $this->facultes->add($faculte);
            $faculte->addUniversity($this);
        }

        return $this;
    }

    public function removeFaculte(Faculte $faculte): static
    {
        if ($this->facultes->removeElement($faculte)) {
            $faculte->removeUniversity($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Domain>
     */
    public function getDomains(): Collection
    {
        return $this->domains;
    }

    public function addDomain(Domain $domain): static
    {
        if (!$this->domains->contains($domain)) {
            $this->domains->add($domain);
            $domain->addUniversity($this);
        }

        return $this;
    }

    public function removeDomain(Domain $domain): static
    {
        if ($this->domains->removeElement($domain)) {
            $domain->removeUniversity($this);
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
            $card->setUniversity($this);
        }

        return $this;
    }

    public function removeCard(Card $card): static
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getUniversity() === $this) {
                $card->setUniversity(null);
            }
        }

        return $this;
    }
}
