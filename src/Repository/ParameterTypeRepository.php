<?php

namespace App\Repository;

use App\Entity\ParameterType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ParameterType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParameterType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParameterType[]    findAll()
 * @method ParameterType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParameterTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ParameterType::class);
    }

    // /**
    //  * @return ParameterType[] Returns an array of ParameterType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ParameterType
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
