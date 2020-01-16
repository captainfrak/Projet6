<?php

namespace App\Repository;

use App\Entity\ProfilePic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProfilePic|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfilePic|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfilePic[]    findAll()
 * @method ProfilePic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilePicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfilePic::class);
    }

    // /**
    //  * @return ProfilePic[] Returns an array of ProfilePic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfilePic
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
