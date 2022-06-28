<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function checkLogin(string $email, string $password): bool
    {
        $qb = $this->createQueryBuilder('user')
            ->from('App\Entity\User', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email);

        $query = $qb->getQuery();

        return (!$query->execute());
    }

    public function getUnverifiedUsers()
    {
        $qb = $this->createQueryBuilder('user')
            ->from('App\Entity\User', 'u')
            ->where('u.isVerified = NULL')
            ->andWhere('u.createdAt < :time')
            ->setParameter('time', (new \DateTime())->modify('-1 day')->format('Y-m-d H:i:s'));

        $query = $qb->getQuery();

        return $query->execute();
    }

    public function deleteUnverifiedUsers()
    {
        $qb = $this->createQueryBuilder('user')
            ->delete('App\Entity\User', 'u');
//            ->where('u.is_verified = NULL')
//            ->andWhere('u.created_at < :time')
//            ->setParameter('time', (new \DateTime())->modify('-1 day')->format('Y-m-d H:i:s'));

        $query = $qb->getQuery();

        return $query->execute();
    }
}
