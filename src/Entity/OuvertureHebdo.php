<?php

namespace App\Entity;

use App\Repository\OuvertureHebdoRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OuvertureHebdoRepository::class)]
class OuvertureHebdo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Length(10)]
    #[Assert\Choice(choices: ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"])]
    private ?string $jourSemaine = null;
    
    #[ORM\Column]
    private ?int $numJsem = null;


    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank()]
    private ?\DateTime $hOuverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank()]
    private ?\DateTime $hFermeture = null;

    #[ORM\Column(length: 10)]
    private ?string $plage = null;

    #[ORM\Column(length: 50)]
    private ?string $plageTxt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setNumJsem(int $numJsem): static
    {
        $this->numJsem = $numJsem;

        return $this;
    }

    public function getJourSemaine(): ?string
    {
        return $this->jourSemaine;
    }

    public function setJourSemaine(string $jourSemaine): self
    {
        $this->jourSemaine = $jourSemaine;

        return $this;
    }

    public function getHOuverture(): ?\DateTime
    {
        return $this->hOuverture;
    }

    public function setHOuverture(?\DateTime $hOuverture): self
    {
        $this->hOuverture = $hOuverture;

        return $this;
    }

    public function getHFermeture(): ?\DateTime
    {
        return $this->hFermeture;
    }

    public function setHFermeture(?\DateTime $hFermeture): self
    {
        $this->hFermeture = $hFermeture;

        return $this;
    }

    public function getPlage(): ?string
    {
        return $this->plage;
    }

    public function setPlage(string $plage): self
    {
        $this->plage = $plage;

        return $this;
    }

    public function getPlageTxt(): ?string
    {
        return $this->plageTxt;
    }

    public function setPlageTxt(string $plageTxt): self
    {
        $this->plageTxt = $plageTxt;

        return $this;
    }

    public function getNumJsem(): ?int
    {
        return $this->numJsem;
    }
}
