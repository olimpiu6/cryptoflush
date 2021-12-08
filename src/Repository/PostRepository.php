<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository{

    //conection var
    private $con;

    public function __construct(ManagerRegistry $registry){
        parent::__construct($registry, Post::class);
        $this->con = $this->getEntityManager()->getConnection();
    }

    public function findBycategory($category_id, $limit = null, $offset = null){   

        $sql = $limit === null && $offset === null ? 
                    'SELECT post.*, post_category.category_id
                     FROM post 
                     LEFT JOIN post_category ON post_category.post_id = post.id
                     WHERE post_category.category_id = :category_id ORDER BY id DESC'
                :
                    'SELECT post.*, post_category.category_id
                     FROM post 
                     LEFT JOIN post_category ON post_category.post_id = post.id
                     WHERE post_category.category_id = :category_id ORDER BY id DESC
                     LIMIT '. $limit .', ' . $offset;

        $stmt = $this->con->prepare($sql);
        $obj = $stmt->execute([':category_id' => $category_id]);

        $result = $obj->fetchAllAssociative();

        return $result;
        /*return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;*/
    }

    public function findMoreNew($limit = null, $offset = null, $not_included = null){
        $result = false;
        try{
            $sql = 'SELECT post.*
            FROM post 
            WHERE utl <> :utl AND active = :active
            ORDER BY id DESC
            LIMIT '. $limit .', ' . $offset;

            $stmt = $this->con->prepare($sql);
            $obj = $stmt->execute([':utl' => $not_included, ':active'=>1]);
            $result = $obj->fetchAllAssociative();

        }catch(\Exception $e){
            $result = false;
        }
        
        return $result;
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
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
