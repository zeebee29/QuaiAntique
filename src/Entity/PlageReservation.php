<?php

namespace App\Entity;

use App\Repository\PlageReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlageReservationRepository::class)]
class PlageReservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    private ?string $midiSoir = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    private ?\DateTimeInterface $heurePlage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMidiSoir(): ?string
    {
        return $this->midiSoir;
    }

    public function setMidiSoir(string $midiSoir): self
    {
        $this->midiSoir = $midiSoir;

        return $this;
    }

    public function getHeurePlage(): ?\DateTimeInterface
    {
        return $this->heurePlage;
    }

    public function setHeurePlage(\DateTimeInterface $heurePlage): self
    {
        $this->heurePlage = $heurePlage;

        return $this;
    }
    public function __toString()
    {
        return $this->heurePlage->format('H:i');
    }
}
