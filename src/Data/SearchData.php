<?php

namespace App\Data;

use App\Entity\Artiste;
use App\Entity\Restaurant;

class SearchData
{
    /**
     * @var string
     */
    public $q = '';

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