<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant
 *
 * @ORM\Table(name="restaurant")
 * @ORM\Entity
 */
class Restaurant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine", type="string", length=255, nullable=false)
     */
    private $domaine;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=225, nullable=false)
     */
    private $owner;

    /**
     * @var int
     *
     * @ORM\Column(name="nb", type="integer", nullable=false)
     */
    private $nb;

    /**
     * @param string $nom
     * @param string $adresse
     * @param string $domaine
     * @param string $owner
     * @param int $nb
     */
    public function __construct(string $nom, string $adresse, string $domaine, string $owner, int $nb)
    {
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->domaine = $domaine;
        $this->owner = $owner;
        $this->nb = $nb;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getDomaine(): string
    {
        return $this->domaine;
    }

    /**
     * @param string $domaine
     */
    public function setDomaine(string $domaine): void
    {
        $this->domaine = $domaine;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     */
    public function setOwner(string $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return int
     */
    public function getNb(): int
    {
        return $this->nb;
    }

    /**
     * @param int $nb
     */
    public function setNb(int $nb): void
    {
        $this->nb = $nb;
    }


}
