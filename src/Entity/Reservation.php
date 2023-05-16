<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\DateTime(format: 'd/m/Y h:i:s')]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(nullable: true, type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\DateTime(format: 'd/m/Y h:i:s')]
    private ?\DateTime $modifiedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    //   #[Assert\DateTime(format: 'd/m/Y h:i:s')]
    #[Assert\DateTime()]
    private ?\DateTime $dateReservation = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    private ?int $nbConvive = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(255)]
    private ?string $allergie = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull()]
    private ?User $user = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    private ?string $midiSoir = null;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->modifiedAt = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTime
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTime $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getDateReservation(): ?\DateTime
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTime $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getNbConvive(): ?int
    {
        return $this->nbConvive;
    }

    public function setNbConvive(int $nbConvive): self
    {
        $this->nbConvive = $nbConvive;

        return $this;
    }

    public function getAllergie(): ?string
    {
        return $this->allergie;
    }

    public function setAllergie(?string $allergie): self
    {
        $this->allergie = $allergie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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
}
