<?php

namespace App\Repository;

use App\Entity\TrickPic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TrickPic|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickPic|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickPic[]    findAll()
 * @method TrickPic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickPicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickPic::class);
    }

    // /**
    //  * @return TrickPic[] Returns an array of TrickPic objects
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
    public function findOneBySomeField($value): ?TrickPic
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
