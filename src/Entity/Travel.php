<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TravelRepository")
 */
class Travel
{
    use \BaseEntityTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $departure;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $distance_traveled;


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDeparture(): ?\DateTimeInterface
    {
        return $this->departure;
    }

    public function setDeparture(?\DateTimeInterface $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getDistanceTraveled(): ?float
    {
        return $this->distance_traveled;
    }

    public function setDistanceTraveled(?float $distance_traveled): self
    {
        $this->distance_traveled = $distance_traveled;

        return $this;
    }
}
