<?php

namespace App\Repository;

use App\Entity\Artiste;
use App\Search\ArtisteSearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Artiste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artiste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artiste[]    findAll()
 * @method Artiste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artiste::class);
    }

    public function findSearch(ArtisteSearchData $search) : array
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('g','a')
            ->join('a.typeDeMusique','g');

        if(!empty($search->nom)) {
            $query = $query
                ->andWhere('a.nomArtiste LIKE :nom')
                ->setParameter('nom', "%{$search->nom}%");
        }

        if(!empty($search->Genre)){
            $query =$query
                ->andWhere('a.typeDeMusique = :typeDeMusique')
                ->setParameter('typeDeMusique', $search->Genre);
        }

        return $query->getQuery()->getResult();

    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Artiste $entity, bool $flush = true): void
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
    public function remove(Artiste $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Artiste[] Returns an array of Artiste objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Artiste
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
