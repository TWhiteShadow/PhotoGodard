<?php

namespace App\Repository;

use App\Entity\FooterLinks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FooterLinks>
 *
 * @method FooterLinks|null find($id, $lockMode = null, $lockVersion = null)
 * @method FooterLinks|null findOneBy(array $criteria, array $orderBy = null)
 * @method FooterLinks[]    findAll()
 * @method FooterLinks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FooterLinksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FooterLinks::class);
    }

    //    /**
    //     * @return FooterLinks[] Returns an array of FooterLinks objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FooterLinks
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
