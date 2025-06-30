<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProvinceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;  


#[ORM\Table(name: 'province')]
#[ApiResource(
    normalizationContext: ['groups' => ['province:read']],
    denormalizationContext: ['groups' => ['province:write']]
)]
#[ORM\Entity(repositoryClass: ProvinceRepository::class)]
class Province
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['province:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['province:read', 'province:write'])]
    private ?string $name = null;

    /**
     * @var Collection<int, University>
     */
    #[ORM\OneToMany(targetEntity: University::class, mappedBy: 'province')]
    #[Groups(['province:read'])]
    private Collection $universities;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'province')]
    #[Groups(['province:read'])]
    private Collection $user;

    public function __construct()
    {
        $this->universities = new ArrayCollection();
        $this->user = new ArrayCollection();
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
            $university->setProvince($this);
        }

        return $this;
    }

    public function removeUniversity(University $university): static
    {
        if ($this->universities->removeElement($university)) {
            // set the owning side to null (unless already changed)
            if ($university->getProvince() === $this) {
                $university->setProvince(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setProvince($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProvince() === $this) {
                $user->setProvince(null);
            }
        }

        return $this;
    }
}
