<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ApiResource]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Coach $coach = null;

    #[ORM\OneToOne(inversedBy: 'game', cascade: ['persist', 'remove'])]
    private ?CalculationElo $calculation = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: ToPlay::class, cascade: ["persist"])]
    private Collection $toPlays;

    public function __construct()
    {
        $this->toPlays = new ArrayCollection();
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

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(?Coach $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getCalculation(): ?CalculationElo
    {
        return $this->calculation;
    }

    public function setCalculation(?CalculationElo $calculation): self
    {
        $this->calculation = $calculation;

        return $this;
    }


    public function getToPlays(): array
    {
        return $this->toPlays->getValues();
    }

    public function addToPlay(ToPlay $toPlay): self
    {
        if (!$this->toPlays->contains($toPlay)) {
            $this->toPlays[] = $toPlay;
            $toPlay->setGame($this);
        }

        return $this;
    }

    public function removeToPlay(ToPlay $toPlay): self
    {
        if ($this->toPlays->removeElement($toPlay)) {
            // set the owning side to null (unless already changed)
            if ($toPlay->getGame() === $this) {
                $toPlay->setGame(null);
            }
        }

        return $this;
    }
}
