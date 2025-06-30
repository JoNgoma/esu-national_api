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
#[ApiResource(
    normalizationContext: [
        'groups' => ['university:read', 'user:read'],
        'enable_max_depth' => true,
        'max_depth' => 2
    ],
    denormalizationContext: [
        'groups' => ['university:write'],
        'enable_max_depth' => true,
        'max_depth' => 2
    ]
)]
#[ORM\Entity(repositoryClass: UniversityRepository::class)]
class University
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['university:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['university:read', 'university:write', 'user:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['university:read', 'university:write'])]
    private ?string $postOfficeBox = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['university:read', 'university:write'])]
    private ?string $adress = null;

    #[ORM\Column(length: 16)]
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
    #[groups(['university:read', 'university:write'])]
    private Collection $systeme;

    #[ORM\ManyToOne(inversedBy: 'universities')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['university:read', 'university:write'])]
    private ?Province $province = null;

    public function __construct()
    {
        $this->systeme = new ArrayCollection();
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
}
