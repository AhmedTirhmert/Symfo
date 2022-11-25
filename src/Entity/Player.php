<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'Name already taken', groups: ['New'])]

class Player
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'name', type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\GreaterThan(150, null, 'Minimum height to join is 150cm ')]
    private ?string $height = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\Positive(message: 'Wieght can\'t be zero', groups: ['update'])]
    private ?string $weight = null;

    #[ORM\Column(nullable: false, unique: true)]
    #[Assert\NotBlank(message: 'Fifa can not be blank', groups: ['Edit'])]
    private ?int $fifaApiId = null;

    #[ORM\Column(nullable: false, unique: true)]
    private ?int $player_api_id = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    private ?Team $team_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getFifaApiId(): ?int
    {
        return $this->fifaApiId;
    }

    public function setFifaApiId(?int $fifaApiId): self
    {
        $this->fifaApiId = $fifaApiId;

        return $this;
    }

    public function getPlayerApiId(): ?int
    {
        return $this->player_api_id;
    }

    public function setPlayerApiId(int $player_api_id): self
    {
        $this->player_api_id = $player_api_id;

        return $this;
    }

    public function getTeamId(): ?Team
    {
        return $this->team_id;
    }

    public function setTeamId(?Team $team_id): self
    {
        $this->team_id = $team_id;

        return $this;
    }
}
