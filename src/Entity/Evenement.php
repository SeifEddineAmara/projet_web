<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="idArtiste", columns={"Id_Artiste"}), @ORM\Index(name="Id_Restaurant", columns={"Id_Restaurant"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Evenement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvenement;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Evenement", type="string", length=20, nullable=false)
     */
    private $nomEvenement;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date_Evenement", type="date", nullable=true, options={"default"="NULL"})
     */
    private $dateEvenement = 'NULL';

    /**
     * @var \Artiste
     *
     * @ORM\ManyToOne(targetEntity="Artiste")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Artiste", referencedColumnName="Id_Artiste")
     * })
     */
    private $idArtiste;

    /**
     * @var \Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Restaurant", referencedColumnName="id")
     * })
     */
    private $idRestaurant;

    public function getIdEvenement(): ?int
    {
        return $this->idEvenement;
    }

    public function getNomEvenement(): ?string
    {
        return $this->nomEvenement;
    }

    public function setNomEvenement(string $nomEvenement): self
    {
        $this->nomEvenement = $nomEvenement;

        return $this;
    }

    public function getDateEvenement(): ?\DateTimeInterface
    {
        return $this->dateEvenement;
    }

    public function setDateEvenement(?\DateTimeInterface $dateEvenement): self
    {
        $this->dateEvenement = $dateEvenement;

        return $this;
    }

    public function getIdArtiste(): ?Artiste
    {
        return $this->idArtiste;
    }

    public function setIdArtiste(?Artiste $idArtiste): self
    {
        $this->idArtiste = $idArtiste;

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


}
