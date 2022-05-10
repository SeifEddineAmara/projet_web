<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    public function findByDate()
    {
        return $this->createQueryBuilder('Menu')
            ->orderBy('type','DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findByDate2()
    {
        return $this->createQueryBuilder('Menu')
            ->orderBy('type','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findMale()
    {
        return $this->createQueryBuilder('Reservation')
            ->where('Reservation.idUser.nom Like :idUser')
            ->setParameter('idUser', '%seif%')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findFemale()
    {
        return $this->createQueryBuilder('Reservation')
            ->where('Reservation.idUser.nom Like :idUser')
            ->setParameter('idUser', '%houssem%')
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
            ->select('COUNT(c) AS loo, (c.type) AS usr')
            ->groupBy('usr');


        return $qb->getQuery()
            ->getResult();
    }

}