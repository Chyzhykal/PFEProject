<?php

namespace App\Repository;

use App\Entity\TEventMerge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TEventMerge|null find($id, $lockMode = null, $lockVersion = null)
 * @method TEventMerge|null findOneBy(array $criteria, array $orderBy = null)
 * @method TEventMerge[]    findAll()
 * @method TEventMerge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TEventMergeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TEventMerge::class);
    }

    // /**
    //  * @return TEventMerge[] Returns an array of TEventMerge objects
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
    public function findOneBySomeField($value): ?TEventMerge
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
