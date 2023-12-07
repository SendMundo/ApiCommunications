<?php

namespace App\Repository;

use App\Entity\TunnelInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TunnelInformation>
 *
 * @method TunnelInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TunnelInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TunnelInformation[]    findAll()
 * @method TunnelInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TunnelInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TunnelInformation::class);
    }

//    /**
//     * @return TunnelInformation[] Returns an array of TunnelInformation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TunnelInformation
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
