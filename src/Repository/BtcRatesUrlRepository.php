<?php

namespace App\Repository;

use App\Entity\BtcRatesUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BtcRatesUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method BtcRatesUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method BtcRatesUrl[]    findAll()
 * @method BtcRatesUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BtcRatesUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BtcRatesUrl::class);
    }

    // /**
    //  * @return BtcRatesUrl[] Returns an array of BtcRatesUrl objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BtcRatesUrl
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
