<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ApiResource(
    collectionOperations: [
        'delete' => [
            'security' => 'is_granted("ROLE_ADMIN")',
        ],
        'patch' => [
            'security' => 'is_granted("ROLE_ADMIN")',
        ],
        'put' => [
            'security' => 'is_granted("ROLE_ADMIN")',
        ],
    ]
)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: CalculationElo::class, cascade: ['persist', 'remove'])]
    private Collection $calculation;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: ToPlay::class, cascade: ['persist'])]
    private Collection $toPlays;

    public function __construct()
    {
        $this->toPlays = new ArrayCollection();
        $this->calculation = new ArrayCollection();
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

    public function getCalculation(): array
    {
        return $this->calculation->getValues();
    }

    public function addCalculation(CalculationElo $calculationElo): self
    {
        if (!$this->calculation->contains($calculationElo)) {
            $this->calculation[] = $calculationElo;
            $calculationElo->setGame($this);
        }

        return $this;
    }

    public function removeCalculation(CalculationElo $calculationElo): self
    {
        if ($this->calculation->removeElement($calculationElo)) {
            // set the owning side to null (unless already changed)
            if ($calculationElo->getGame() === $this) {
                $calculationElo->setGame(null);
            }
        }

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
