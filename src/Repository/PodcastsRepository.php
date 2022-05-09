<?php

namespace App\Repository;

use App\Entity\Podcasts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Podcasts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Podcasts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Podcasts[]    findAll()
 * @method Podcasts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PodcastsRepository extends ServiceEntityRepository
{




    public function findByNom($txt)
    {
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT p from APP\Entity\Podcasts p where p.title like :txt or p.rating like :txt")
            ->setParameter('txt','%'.$txt.'%');
        return $query->getResult();
    }


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Podcasts::class);
    }

      //  /**
     // * @return Podcasts[] Returns an array of Podcasts objects
     //*/
    
    //public function findByExampleField($value)
   // {
    //    return $this->createQueryBuilder('e')
    //        ->andWhere('e.exampleField = :val')
     ///       ->setParameter('val', $value)
     //       ->orderBy('e.id', 'ASC')
       //     ->setMaxResults(10)
      //      ->getQuery()
      //      ->getResult()
     //   ;
    //}
  

    /*
    public function findOneBySomeField($value): ?Podcasts
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    
   /**
     * @return void
     */
    public function countbyCategorie($id)
    {
        $query= $this->createQueryBuilder('p')
            ->join('p.idcategorie','c')            
            ->addselect('COUNT(p) as count')
            ->where('p.idcategorie=:idcategorie')
            ->setParameter('idcategorie',$id)

        ;
        return $query->getQuery()->getResult();
    }






}
