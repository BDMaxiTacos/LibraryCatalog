<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function latest(){
        return  $this->createQueryBuilder('b')
                    ->orderBy('b.publication_date', 'DESC')
                    ->setMaxResults(3)
                    ->getQuery()
                    ->getResult();
    }

    public function searchBy(array $options){
        $qb = $this->createQueryBuilder('b');

        foreach ($options as $key => $value) {
            
            switch($value['type']){
                case '==':
                    $qb = $qb->andWhere("b.".$key." = ".$value['value']);
                    break;
                case 'like':
                    $qb = $qb->andWhere("b.".$key." LIKE '%" . $value['value'] . "%'");
                    break;
                case 'date':
                    $qb = $qb->andWhere("b.".$key." < '". $value['value']->format('Y-m-d H:i:s')."'");
                    break;
            }
        }
        // dd($qb->getQuery()->getSQL());

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
