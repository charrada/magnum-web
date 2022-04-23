<?php
namespace App\Repository;

use App\Entity\History;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function clearHistory(User $user)
    {
        $entityManager = $this->getEntityManager();

        $qb = $em->createQueryBuilder();
        $query = $qb->delete('History')
                    ->where('history.userID = :userID')
                    ->setParameter('userID', $user->getID())
                    ->getQuery();

        $query->execute();
    }
}
