<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CityRepository::class)]
#[UniqueEntity(fields: ['name', 'country_id'], message: 'City already existe')]
class City
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

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    private ?Country $country_id = null;

    #[ORM\OneToMany(mappedBy: 'city_id', targetEntity: Stadium::class)]
    private Collection $stadiums;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(nullable: true)]
    private ?int $population = null;

    public function __construct()
    {
        $this->timeStamps();
        $this->stadiums = new ArrayCollection();
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

    public function getCountryId(): ?Country
    {
        return $this->country_id;
    }

    public function setCountryId(?Country $country_id): self
    {
        $this->country_id = $country_id;

        return $this;
    }

    /**
     * @return Collection<int, Stadium>
     */
    public function getStadiums(): Collection
    {
        return $this->stadiums;
    }

    public function addStadium(Stadium $stadium): self
    {
        if (!$this->stadiums->contains($stadium)) {
            $this->stadiums->add($stadium);
            $stadium->setCityId($this);
        }

        return $this;
    }

    public function removeStadium(Stadium $stadium): self
    {
        if ($this->stadiums->removeElement($stadium)) {
            // set the owning side to null (unless already changed)
            if ($stadium->getCityId() === $this) {
                $stadium->setCityId(null);
            }
        }

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

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
}
