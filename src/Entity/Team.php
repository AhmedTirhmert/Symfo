<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;


#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
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

    public function getApiId(): ?int
    {
        return $this->apiId;
    }

    public function setApiId(int $apiId): self
    {
        $this->apiId = $apiId;

        return $this;
    }

    public function getFifaApiId(): ?int
    {
        return $this->fifaApiId;
    }

    public function setFifaApiId(int $fifaApiId): self
    {
        $this->fifaApiId = $fifaApiId;

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

    public function getTeamLongName(): ?string
    {
        return $this->team_long_name;
    }

    public function setTeamLongName(string $team_long_name): self
    {
        $this->team_long_name = $team_long_name;

        return $this;
    }

    public function getTeamShortName(): ?string
    {
        return $this->team_short_name;
    }

    public function setTeamShortName(string $team_short_name): self
    {
        $this->team_short_name = $team_short_name;

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
