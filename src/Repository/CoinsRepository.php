<?php

namespace App\Repository;

use App\Entity\Coins;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Coins|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coins|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coins[]    findAll()
 * @method Coins[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoinsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coins::class);
        $this->con = $this->getEntityManager()->getConnection();
    }

    public function findLimit($limit, $offset){
        $result = false;
        try{
            $sql = 'SELECT *
            FROM coins 
            ORDER BY id ASC
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
    //  * @return Coins[] Returns an array of Coins objects
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
    public function findOneBySomeField($value): ?Coins
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
