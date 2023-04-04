<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ApiResource]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timeStamp = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messages')]
    private ?User $send = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messages')]
    private ?User $receive = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getTimeStamp(): ?\DateTimeInterface
    {
        return $this->timeStamp;
    }

    public function setTimeStamp(\DateTimeInterface $timeStamp): self
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getSend(): ?User
    {
        return $this->send;
    }

    /**
     * @param User|null $send
     */
    public function setSend(?User $send): void
    {
        $this->send = $send;
    }

    /**
     * @return User|null
     */
    public function getReceive(): ?User
    {
        return $this->receive;
    }

    /**
     * @param User|null $receive
     */
    public function setReceive(?User $receive): void
    {
        $this->receive = $receive;
    }

}
