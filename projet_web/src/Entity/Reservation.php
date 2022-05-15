<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="Id_Table", columns={"Id_Table"}), @ORM\Index(name="Id_Resaturent", columns={"Id_Restaurant"}), @ORM\Index(name="Id_User", columns={"Id_User"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReservation;

    /**
     * @var int
     * @Assert\NotBlank
     * @ORM\Column(name="Heure", type="integer", nullable=false)
     */
    private $heure;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="Date", type="string", length=225, nullable=false)
     */
    private $date;

    /**
     * @var \Restaurant
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Restaurant", referencedColumnName="id")
     * })
     */
    private $idRestaurant;

    /**
     * @var \TableRestaurant
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="TableRestaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Table", referencedColumnName="Id_Table")
     * })
     */
    private $idTable;

    /**
     * @var \User
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_User", referencedColumnName="id")
     * })
     */
    private $idUser;




    public function getIdReservation(): ?int
    {
        return $this->idReservation;
    }

    public function getHeure(): ?int
    {
        return $this->heure;
    }

    public function setHeure(int $heure): self
    {
        $this->heure = $heure;

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

    public function getIdRestaurant(): ?Restaurant
    {
        return $this->idRestaurant;
    }

    public function setIdRestaurant(?Restaurant $idRestaurant): self
    {
        $this->idRestaurant = $idRestaurant;

        return $this;
    }

    public function getIdTable(): ?TableRestaurant
    {
        return $this->idTable;
    }

    public function setIdTable(?TableRestaurant $idTable): self
    {
        $this->idTable = $idTable;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


    public function jsonSerialize(): array
    {
        return array(
            'id' => $this->idReservation,
            'heure' => $this->heure,
            'date' => $this->date,
            'restaurant' => $this->idRestaurant,
            'table' => $this->idTable,
            'user' => $this->idUser

        );
    }

    public function setUp($heure, $date, $restaurant, $table, $user)
    {
        $this->heure = $heure;
        $this->date = $date;
        $this->idRestaurant = $restaurant;
        $this->idTable = $table;
        $this->idUser = $user;

    }


}
