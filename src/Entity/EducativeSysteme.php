<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EducativeSystemeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducativeSystemeRepository::class)]
#[ApiResource]
class EducativeSysteme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameEduc = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptEduc = null;

    #[ORM\ManyToOne(inversedBy: 'educativeSystemes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

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
}
