<?php

namespace App\Repository;

use App\Entity\Tickets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tickets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tickets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tickets[]    findAll()
 * @method Tickets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tickets::class);
    }

    public function countTickets($user){
      return   $queryBuilder = $this->createQueryBuilder('t')
         ->select('COUNT(t)')
        ->where('t.user = :user')
          ->andWhere('t.archived = 0')
        ->setParameter('user',$user)
          ->getQuery()->getSingleScalarResult();

}

    public function showTickets($user){
        return   $queryBuilder = $this->createQueryBuilder('t')
            ->select('t.depotdate')
            ->where('t.user = :user')
            ->andWhere('t.archived = 0')
            ->setParameter('user',$user)
            ->getQuery()->getResult();

    }

    public function searchWithFlashingOption($name,$isFlashed){
        return $queryBuilder = $this->createQueryBuilder("t")

            ->andWhere('t.name LIKE  :name')
            ->andWhere('t.flashingdepot LIKE :isFlashed')
            ->andWhere('t.archived = 1')
            ->setParameter('name', '%'.$name.'%')
            ->setParameter('isFlashed', $isFlashed)
            ->getQuery()
            ->execute();



    }

    public function searchWithoutFlashingOption($name){
        return $queryBuilder = $this->createQueryBuilder("t")
            ->andWhere('t.name LIKE  :name')
            ->andWhere('t.archived = 1')
            ->setParameter('name', '%'.$name.'%')
            ->getQuery()
            ->execute();



    }





    // /**
    //  * @return Tickets[] Returns an array of Tickets objects
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
    public function findOneBySomeField($value): ?Tickets
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
