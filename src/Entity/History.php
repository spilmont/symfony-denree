<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoryRepository")
 */
class History
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
     * @ORM\Column(type="smallint")
     */
    private $flashingdepot;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbtickets;

    /**
     * @ORM\Column(type="integer")
     */
    private $semaine;

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

    public function getFlashingdepot(): ?int
    {
        return $this->flashingdepot;
    }

    public function setFlashingdepot(int $flashingdepot): self
    {
        $this->flashingdepot = $flashingdepot;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getNbtickets(): ?int
    {
        return $this->nbtickets;
    }

    public function setNbtickets(?int $nbtickets): self
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
}
