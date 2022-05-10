<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function findByDate()
    {
        return $this->createQueryBuilder('Reservation')
            ->orderBy('Reservation.idRestaurant','DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findByDate2()
    {
        return $this->createQueryBuilder('Reservation')
            ->orderBy('Reservation.idRestaurant','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findMale()
    {
        return $this->createQueryBuilder('Reservation')
            ->where('Reservation.idUser.name Like :idUser.name')
            ->setParameter('idUser.name', '%seif%')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findFemale()
    {
        return $this->createQueryBuilder('Reservation')
            ->where('Reservation.idUser.name Like :idUser.name')
            ->setParameter('idUser.name', '%houssem%')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getNB()
    {

        $qb = $this->createQueryBuilder('c')
            ->select('COUNT(c) AS loo, (c.idUser) AS usr')
            ->groupBy('usr');


        return $qb->getQuery()
            ->getResult();
    }

    public function findByHeure($produit)
    {
        return $this->createQueryBuilder('r')
            ->where('r.heure Like :heure ')
            ->setParameter('heure ', '%'.$produit.'%')
            ->getQuery()
            ->getResult()
            ;
    }

}