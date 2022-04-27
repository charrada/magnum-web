<?php


namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;


class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    /**
     * @return Users
     */
    public function findMatchingUsers(Users $user): array
    {
        $man = $this->getEntityManager();

        $query = $man
            ->createQuery(
                'SELECT u
            FROM App\Entity\Users u
            WHERE u.id = :id OR u.username = :username OR u.email = :email'
            )
            ->setParameters([
                "id" => $user->getId(),
                "username" => $user->getUsername(),
                "email" => $user->getEmail(),
            ]);

        return $query->getResult();
    }

    public function loadUserByUsername($usernameOrEmail): ?User
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
                'SELECT u
                FROM App\Entity\Users u
                WHERE u.username = :query
                OR u.email = :query'
            )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();
    }

}
