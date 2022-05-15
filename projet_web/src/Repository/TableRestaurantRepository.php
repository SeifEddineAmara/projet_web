<?php

namespace App\Repository;

use App\Entity\TableRestaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TableRestaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method TableRestaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method TableRestaurant[]    findAll()
 * @method TableRestaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableRestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TableRestaurant::class);
    }
}
