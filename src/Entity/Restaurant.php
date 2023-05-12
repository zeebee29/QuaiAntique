<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Length(500)]
    private ?string $adresse = null;

    #[ORM\Column(length: 12)]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Length(12)]
    private ?string $tel = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\GreaterThan(0)]
    private ?int $capacite = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\GreaterThanOrEqual(10)]
    private ?int $gapResa = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    private ?int $delayBeforeEnd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getGapResa(): ?int
    {
        return $this->gapResa;
    }

    public function setGapResa(int $gapResa): self
    {
        $this->gapResa = $gapResa;

        return $this;
    }

    public function getDelayBeforeEnd(): ?int
    {
        return $this->delayBeforeEnd;
    }

    public function setDelayBeforeEnd(int $delayBeforeEnd): self
    {
        $this->delayBeforeEnd = $delayBeforeEnd;

        return $this;
    }
}
