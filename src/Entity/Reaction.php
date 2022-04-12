<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reaction
 *
 * @ORM\Table(name="reaction", indexes={@ORM\Index(name="Id_Publication", columns={"Id_Publication"}), @ORM\Index(name="Id_User", columns={"Id_User"})})
 * @ORM\Entity
 */
class Reaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Reaction", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReaction;

    /**
     * @var int
     *
     * @ORM\Column(name="Type_Reaction", type="integer", nullable=false)
     */
    private $typeReaction;

    /**
     * @var \Publication
     *
     * @ORM\ManyToOne(targetEntity="Publication")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Publication", referencedColumnName="Id_Publication")
     * })
     */
    private $idPublication;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_User", referencedColumnName="id")
     * })
     */
    private $idUser;


}
