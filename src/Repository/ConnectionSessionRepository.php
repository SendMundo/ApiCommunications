<?php

namespace App\Repository;

use App\Entity\ConnectionSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConnectionSession>
 *
 * @method ConnectionSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConnectionSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConnectionSession[]    findAll()
 * @method ConnectionSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnectionSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConnectionSession::class);
    }

//    /**
//     * @return ConnectionSession[] Returns an array of ConnectionSession objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ConnectionSession
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
