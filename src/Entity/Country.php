<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'Country already existe')]
class Country
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

    #[ORM\OneToMany(mappedBy: 'country_id', targetEntity: League::class)]
    private Collection $leagues;

    #[ORM\OneToMany(mappedBy: 'country_id', targetEntity: City::class)]
    private Collection $cities;

    #[ORM\ManyToOne(inversedBy: 'countries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Region $region = null;

    #[ORM\Column(nullable: true)]
    private ?int $population = null;

    #[ORM\Column(nullable: true)]
    private ?int $area = null;

    public function __construct()
    {
        $this->timeStamps();
        $this->leagues = new ArrayCollection();
        $this->cities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getname(): ?string
    {
        return $this->name;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, League>
     */
    public function getLeagues(): Collection
    {
        return $this->leagues;
    }

    public function addLeague(League $league): self
    {
        if (!$this->leagues->contains($league)) {
            $this->leagues->add($league);
            $league->setCountryId($this);
        }

        return $this;
    }

    public function removeLeague(League $league): self
    {
        if ($this->leagues->removeElement($league)) {
            // set the owning side to null (unless already changed)
            if ($league->getCountryId() === $this) {
                $league->setCountryId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setCountryId($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getCountryId() === $this) {
                $city->setCountryId(null);
            }
        }

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(?int $population): self
    {
        $this->population = $population;

        return $this;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(?int $area): self
    {
        $this->area = $area;

        return $this;
    }
}
