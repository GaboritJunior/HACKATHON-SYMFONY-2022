<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $username;

    #[ORM\Column(type: 'integer')]
    private $money;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Guild::class, inversedBy: 'characters')]
    private $guild;

    #[ORM\ManyToOne(targetEntity: Speciality::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $speciality;

    #[ORM\ManyToOne(targetEntity: Faction::class, inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private $faction;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: CharacterEquipment::class, orphanRemoval: true, cascade: ["persist"])]
    private $equipments;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: CharacterResource::class, orphanRemoval: true, cascade: ["persist"])]
    private $resources;

    public function __construct()
    {
        $this->equipments = new ArrayCollection();
        $this->resources = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getUsername();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function setMoney(int $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGuild(): ?Guild
    {
        return $this->guild;
    }

    public function setGuild(?Guild $guild): self
    {
        $this->guild = $guild;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    public function getFaction(): ?Faction
    {
        return $this->faction;
    }

    public function setFaction(?Faction $faction): self
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * @return Collection<int, CharacterEquipment>
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(CharacterEquipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->setPlayer($this);
        }

        return $this;
    }

    public function removeEquipment(CharacterEquipment $equipment): self
    {
        if ($this->equipments->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getPlayer() === $this) {
                $equipment->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CharacterResource>
     */
    public function getResources(): Collection
    {
        return $this->resources;
    }

    public function addResource(CharacterResource $resource): self
    {
        if (!$this->resources->contains($resource)) {
            $this->resources[] = $resource;
            $resource->setPlayer($this);
        }

        return $this;
    }

    public function removeResource(CharacterResource $resource): self
    {
        if ($this->resources->removeElement($resource)) {
            // set the owning side to null (unless already changed)
            if ($resource->getPlayer() === $this) {
                $resource->setPlayer(null);
            }
        }

        return $this;
    }


}
