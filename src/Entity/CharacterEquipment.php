<?php

namespace App\Entity;

use App\Repository\CharacterEquipmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterEquipmentRepository::class)]
class CharacterEquipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $ilvl;

    #[ORM\Column(type: 'boolean')]
    private $equiped;

    #[ORM\ManyToOne(targetEntity: Equipment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $equipment;

    #[ORM\ManyToOne(targetEntity: Character::class, inversedBy: 'equipments')]
    #[ORM\JoinColumn(nullable: false)]
    private $player;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIlvl(): ?int
    {
        return $this->ilvl;
    }

    public function setIlvl(int $ilvl): self
    {
        $this->ilvl = $ilvl;

        return $this;
    }

    public function getEquiped(): ?bool
    {
        return $this->equiped;
    }

    public function setEquiped(bool $equiped): self
    {
        $this->equiped = $equiped;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getPlayer(): ?Character
    {
        return $this->player;
    }

    public function setPlayer(?Character $player): self
    {
        $this->player = $player;

        return $this;
    }
}
