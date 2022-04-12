<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     *
     * @ORM\Column(name="Nom_Cour", type="string", length=30, nullable=false)
     */
    private $nomCour;

    /**
     * @var string
     *
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


}
