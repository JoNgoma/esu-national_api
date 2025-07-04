<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]

#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['educative_systeme:read', 'user:read', 'user:write', 'university:read'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    private array $roles = [];

    #[ORM\Column]
    #[Groups(['user:write'])]
    private ?string $password = null;

    /**
     * @var Collection<int, EducativeSysteme>
     */
    #[ORM\OneToMany(targetEntity: EducativeSysteme::class, mappedBy: 'user')]
    #[Groups(['user:read'])] // champs présent uniquement en lecture
    private Collection $educativeSystemes;

    /**
     * @var Collection<int, University>
     */
    #[ORM\OneToMany(targetEntity: University::class, mappedBy: 'user')]
    #[Groups(['user:read'])]
    private Collection $universities;

    #[ORM\ManyToOne(inversedBy: 'user')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read', 'user:write'])]
    private ?Province $province = null;

    /**
     * @var Collection<int, Card>
     */
    #[ORM\OneToMany(targetEntity: Card::class, mappedBy: 'user')]
    private Collection $cards;

    public function __construct()
    {
        $this->educativeSystemes = new ArrayCollection();
        $this->universities = new ArrayCollection();
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // $this->plainPassword = null;
    }

    public function getEducativeSystemes(): Collection
    {
        return $this->educativeSystemes;
    }

    public function addEducativeSysteme(EducativeSysteme $educativeSysteme): static
    {
        if (!$this->educativeSystemes->contains($educativeSysteme)) {
            $this->educativeSystemes->add($educativeSysteme);
            $educativeSysteme->setUser($this);
        }

        return $this;
    }

    public function removeEducativeSysteme(EducativeSysteme $educativeSysteme): static
    {
        if ($this->educativeSystemes->removeElement($educativeSysteme)) {
            if ($educativeSysteme->getUser() === $this) {
                $educativeSysteme->setUser(null);
            }
        }

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
            $university->setUser($this);
        }

        return $this;
    }

    public function removeUniversity(University $university): static
    {
        if ($this->universities->removeElement($university)) {
            // set the owning side to null (unless already changed)
            if ($university->getUser() === $this) {
                $university->setUser(null);
            }
        }

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
            $card->setUser($this);
        }

        return $this;
    }

    public function removeCard(Card $card): static
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getUser() === $this) {
                $card->setUser(null);
            }
        }

        return $this;
    }
}
