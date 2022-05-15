<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Cours
 *
 * @ORM\Table(name="cours", indexes={@ORM\Index(name="ID_Chef", columns={"ID_Chef"})})
 * @ORM\Entity
 */
class Cours
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Cour", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCour;

    /**
     * @var string
     * @Assert\NotBlank(message="nom cour doit étre saisie")
     * @ORM\Column(name="Nom_Cour", type="string", length=30, nullable=false)
     */
    private $nomCour;

    /**
     * @var string
     * @Assert\NotBlank(message="le libelle du cour doit étre saisie")
     * @ORM\Column(name="Libelle_Cour", type="text", length=65535, nullable=false)
     */

    private $libelleCour;

    /**
     * @var \Chefs
     *
     * @ORM\ManyToOne(targetEntity="Chefs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Chef", referencedColumnName="ID_Chef")
     * })
     */
    private $idChef;

    public function getIdCour(): ?int
    {
        return $this->idCour;
    }

    public function getNomCour(): ?string
    {
        return $this->nomCour;
    }

    public function setNomCour(string $nomCour): self
    {
        $this->nomCour = $nomCour;

        return $this;
    }

    public function getLibelleCour(): ?string
    {
        return $this->libelleCour;
    }

    public function setLibelleCour(string $libelleCour): self
    {
        $this->libelleCour = $libelleCour;

        return $this;
    }

    public function getIdChef(): ?Chefs
    {
        return $this->idChef;
    }

    public function setIdChef(?Chefs $idChef): self
    {
        $this->idChef = $idChef;

        return $this;
    }


}
