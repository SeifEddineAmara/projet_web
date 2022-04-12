<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Artiste
 *
 * @ORM\Table(name="artiste")
 * @ORM\Entity
 */
class Artiste
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Artiste", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArtiste;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nom_Artiste", type="string", length=30, nullable=true)
     */
    private $nomArtiste;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type_De_Musique", type="string", length=20, nullable=true)
     */
    private $typeDeMusique;


}
