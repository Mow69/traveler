<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 */
class Picture
{
    use \BaseEntityTrait;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $caption;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;


    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(?string $caption): self
    {
        $this->caption = $caption;

        return $this;
    }


    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
