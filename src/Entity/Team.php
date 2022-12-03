<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[UniqueEntity(fields: ['name', 'shortName'], message: 'Name already taken')]
class Team
{

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity {
        TimestampableEntity::__construct as private timeStamps;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $shortName = null;

    #[ORM\Column(unique: true)]
    private ?int $team_api_id = null;

    #[ORM\Column(unique: true)]
    private ?int $team_fifa_id = null;

    #[ORM\OneToMany(mappedBy: 'team_id', targetEntity: Player::class)]
    private Collection $players;

    #[ORM\ManyToOne(inversedBy: 'teams')]
    private ?League $league_id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Stadium $stadium_id = null;

    public function __construct()
    {
        $this->timeStamps();
        $this->setTeamFifaId(rand(min: 1, max: 10000));
        $this->setTeamApiId(rand(min: 1, max: 10000));
        $this->players = new ArrayCollection();
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

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getTeamApiId(): ?int
    {
        return $this->team_api_id;
    }

    public function setTeamApiId(int $team_api_id): self
    {
        $this->team_api_id = $team_api_id;

        return $this;
    }

    public function getTeamFifaId(): ?int
    {
        return $this->team_fifa_id;
    }

    public function setTeamFifaId(int $team_fifa_id): self
    {
        $this->team_fifa_id = $team_fifa_id;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setTeamId($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getTeamId() === $this) {
                $player->setTeamId(null);
            }
        }

        return $this;
    }

    public function getLeagueId(): ?League
    {
        return $this->league_id;
    }

    public function setLeagueId(?League $league_id): self
    {
        $this->league_id = $league_id;

        return $this;
    }

    public function getStadiumId(): ?Stadium
    {
        return $this->stadium_id;
    }

    public function setStadiumId(?Stadium $stadium_id): self
    {
        $this->stadium_id = $stadium_id;

        return $this;
    }
}
