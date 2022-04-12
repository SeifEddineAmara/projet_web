<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chefs
 *
 * @ORM\Table(name="chefs")
 * @ORM\Entity
 */
class Chefs
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Chef", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idChef;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Chef", type="string", length=30, nullable=false)
     */
    private $nomChef;

    /**
     * @var string
     *
     * @ORM\Column(name="Cours_Associe", type="string", length=100, nullable=false)
     */
    private $coursAssocie;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse_Chef", type="string", length=100, nullable=false)
     */
    private $adresseChef;


}
