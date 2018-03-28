<?php

namespace App\Repository;

use App\Entity\SuggestedProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SuggestedProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuggestedProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuggestedProduct[]    findAll()
 * @method SuggestedProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuggestedProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SuggestedProduct::class);
    }

    public function removeSuggestedItems($id)
    {
        $query = $this->createQueryBuilder('q')
            ->delete(SuggestedProduct::class, 's')
            ->where('s.food =  ?1')
            ->setParameter(1, $id)
            ->getQuery();

        $query->execute();
    }
    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.something = :value')->setParameter('value', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
