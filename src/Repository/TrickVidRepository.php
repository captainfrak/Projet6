<?php

namespace App\Repository;

use App\Entity\TrickVid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TrickVid|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickVid|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickVid[]    findAll()
 * @method TrickVid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickVidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickVid::class);
    }

    // /**
    //  * @return TrickVid[] Returns an array of TrickVid objects
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
    public function findOneBySomeField($value): ?TrickVid
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
