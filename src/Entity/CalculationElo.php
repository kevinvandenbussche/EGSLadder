<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CalculationEloRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalculationEloRepository::class)]
class CalculationElo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $division_game = null;

    #[ORM\Column]
    private ?int $eloInternal = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'calculation')]
    private ?Game $game = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDivisionGame(): ?string
    {
        return $this->division_game;
    }

    public function setDivisionGame(string $division_game): self
    {
        $this->division_game = $division_game;

        return $this;
    }

    public function getEloInternal(): ?int
    {
        return $this->eloInternal;
    }

    public function setEloInternal(int $eloInternal): self
    {
        $this->eloInternal = $eloInternal;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        // unset the owning side of the relation if necessary
        if ($game === null && $this->game !== null) {
            $this->game->setCalculation(null);
        }

        // set the owning side of the relation if necessary
        if ($game !== null && $game->getCalculation() !== $this) {
            $game->setCalculation($this);
        }

        $this->game = $game;

        return $this;
    }
}
