<?php

namespace App\Repository;

use App\Entity\CoinMarketsData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CoinMarketsData|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoinMarketsData|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoinMarketsData[]    findAll()
 * @method CoinMarketsData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoinMarketsDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoinMarketsData::class);
        $this->con = $this->getEntityManager()->getConnection();
    }

    public function findLimit($offset, $limit){
        $result = false;
        try{
            $sql = 'SELECT *
            FROM coin_markets_data 
            WHERE market_cap_rank > 0
            ORDER BY market_cap_rank ASC
            LIMIT '. $offset .', ' . $limit;

            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

        }catch(\Exception $e){
            $result = false;
        }
        
        return $result;
    }

    // /**
    //  * @return CoinMarketsData[] Returns an array of CoinMarketsData objects
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
    public function findOneBySomeField($value): ?CoinMarketsData
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