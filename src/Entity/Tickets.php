<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketsRepository")
 */
class Tickets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbfamilly;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $depotdate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $flashingdepot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tickets")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbtickets;

    /**
     * @ORM\Column(type="integer")
     */
    private $semaine;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived;



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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getNbfamilly(): ?int
    {
        return $this->nbfamilly;
    }

    public function setNbfamilly(int $nbfamilly): self
    {
        $this->nbfamilly = $nbfamilly;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDepotdate(): ?string
    {
        return $this->depotdate;
    }

    public function setDepotdate(string $depotdate): self
    {
        $this->depotdate = $depotdate;

        return $this;
    }

    public function getFlashingdepot(): ?bool
    {
        return $this->flashingdepot;
    }

    public function setFlashingdepot(bool $flashingdepot): self
    {
        $this->flashingdepot = $flashingdepot;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNbtickets(): ?int
    {
        return $this->nbtickets;
    }

    public function setNbtickets(int $nbtickets): self
    {
        $this->nbtickets = $nbtickets;

        return $this;
    }

    public function getSemaine(): ?int
    {
        return $this->semaine;
    }

    public function setSemaine(int $semaine): self
    {
        $this->semaine = $semaine;

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }


}
