<?php

namespace App\Repository;

use App\Entity\TypeDeMusique;
use App\Search\TypeDeMusiqueSearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeDeMusique|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDeMusique|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDeMusique[]    findAll()
 * @method TypeDeMusique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDeMusiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeDeMusique::class);
    }

    public function findSearch(TypeDeMusiqueSearchData $search) : array{
        $query = $this
            ->createQueryBuilder('g');
//        dd($query->getQuery()->getResult());
        if(!empty($search->Genre)){
            $query = $query
                ->andWhere('g.Genre LIKE :genre')
                ->setParameter('genre', "%{$search->Genre}%");
        }
//        dd($query->getQuery());
        return $query->getQuery()->getResult();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TypeDeMusique $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(TypeDeMusique $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return TypeDeMusique[] Returns an array of TypeDeMusique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeDeMusique
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
