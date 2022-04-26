<?php

namespace App\Search;

use App\Entity\Artiste;
use App\Entity\Restaurant;

class EvenementSearchData
{
    /**
     * @var string
     */
    public $nom;

    /**
     * @var \DateTime|null
     */
    public $date;

    /**
     * @var Artiste
     */
    public $artiste;

    /**
     * @var Restaurant
     */
    public $restaurant;

}