<?php

namespace App\Repository;

use App\Entity\CoinsPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CoinsPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoinsPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoinsPrice[]    findAll()
 * @method CoinsPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoinsPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoinsPrice::class);
    }

    // /**
    //  * @return CoinsPrice[] Returns an array of CoinsPrice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CoinsPrice
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
