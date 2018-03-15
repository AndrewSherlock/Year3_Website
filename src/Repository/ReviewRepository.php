<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function changeReviewScore($id, $value)
    {
        $queryRes = $this->createQueryBuilder('r')
            ->where('r.id = :id')->setParameter('id', $id)
            ->getQuery()->getResult();

        $reviewScore = $queryRes[0]->getReviewScore();
        $newScore = intval($value) + $reviewScore;


        $setQuery = $this->createQueryBuilder('u')->update(Review::class, 'r')
            ->set('r.review_score', $newScore)->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()->execute()
            ;

    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('r')
            ->where('r.something = :value')->setParameter('value', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
