<?php

namespace App\Entity;

use App\Repository\RarityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RarityRepository::class)]
class Rarity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $averagePrice;

    #[ORM\Column(type: 'integer')]
    private $ilvlMax;

    #[ORM\Column(type: 'integer')]
    private $ilvlMin;

    #[ORM\Column(type: 'float')]
    private $probability;

    #[ORM\OneToMany(mappedBy: 'rarity', targetEntity: Equipment::class, orphanRemoval: true)]
    private $equipments;

    public function __construct()
    {
        $this->equipments = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAveragePrice(): ?int
    {
        return $this->averagePrice;
    }

    public function setAveragePrice(int $averagePrice): self
    {
        $this->averagePrice = $averagePrice;

        return $this;
    }

    public function getIlvlMax(): ?int
    {
        return $this->ilvlMax;
    }

    public function setIlvlMax(int $ilvlMax): self
    {
        $this->ilvlMax = $ilvlMax;

        return $this;
    }

    public function getIlvlMin(): ?int
    {
        return $this->ilvlMin;
    }

    public function setIlvlMin(int $ilvlMin): self
    {
        $this->ilvlMin = $ilvlMin;

        return $this;
    }

    public function getProbability(): ?float
    {
        return $this->probability;
    }

    public function setProbability(float $probability): self
    {
        $this->probability = $probability;

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->setRarity($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipments->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getRarity() === $this) {
                $equipment->setRarity(null);
            }
        }

        return $this;
    }
}
