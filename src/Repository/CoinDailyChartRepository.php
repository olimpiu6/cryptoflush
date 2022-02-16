<?php

namespace App\Repository;

use App\Entity\CoinDailyChart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CoinDailyChart|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoinDailyChart|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoinDailyChart[]    findAll()
 * @method CoinDailyChart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoinDailyChartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoinDailyChart::class);
    }

    

    // /**
    //  * @return CoinDailyChart[] Returns an array of CoinDailyChart objects
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
    public function findOneBySomeField($value): ?CoinDailyChart
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
