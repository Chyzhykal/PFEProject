<?php

namespace App\Repository;

use App\Entity\TEventPriority;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TEventPriority|null find($id, $lockMode = null, $lockVersion = null)
 * @method TEventPriority|null findOneBy(array $criteria, array $orderBy = null)
 * @method TEventPriority[]    findAll()
 * @method TEventPriority[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TEventPriorityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TEventPriority::class);
    }

    // /**
    //  * @return TEventPriority[] Returns an array of TEventPriority objects
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
    public function findOneBySomeField($value): ?TEventPriority
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
