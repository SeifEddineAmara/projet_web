<?php

namespace App\Repository;

use App\Search\EvenementSearchData;
use App\Entity\Artiste;
use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function findSearch(EvenementSearchData $search) : array
    {
         $query = $this
             ->createQueryBuilder('e')
             ->select('a', 'e')
             ->join('e.Artiste','a');

         if (!empty($search->nom)) {
             $query = $query
                 ->andWhere('e.nomEvenement LIKE :nom')
                 ->setParameter('nom', "%{$search->nom}%");
         }

         if (!empty($search->date)){
             $query = $query
                 ->andWhere('e.dateEvenement = :date')
                 ->setParameter('date', "{$search->date->format('Y-m-d')}");
         }

         if (!empty($search->artiste)) {
             $query = $query
                 ->andWhere('e.Artiste = :artiste')
                 ->setParameter('artiste',$search->artiste);
         }

        if (!empty($search->restaurant)) {
            $query = $query
                ->andWhere('e.Restaurant = :restaurant')
                ->setParameter('restaurant',$search->restaurant);
        }
//        dd($query->getQuery()->getResult());
         return $query->getQuery()->getResult();

    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Evenement $entity, bool $flush = true): void
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
    public function remove(Evenement $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Evenement[] Returns an array of Evenement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Evenement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
