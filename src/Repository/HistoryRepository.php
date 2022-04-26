<?php
namespace App\Repository;

use App\Entity\History;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function erase(Users $user)
    {
        $man = $this->getEntityManager();

        $qb = $man->createQueryBuilder();
        $qb->delete('App\Entity\History', 'h')
           ->where('h.user = :user')
           ->setParameter('user', $user)
           ->getQuery()->execute();
    }
}
