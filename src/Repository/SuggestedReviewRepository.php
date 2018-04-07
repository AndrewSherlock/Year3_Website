<?php
/**
 * comment for the file
 */
namespace App\Repository;

use App\Entity\SuggestedReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Repository for the suggested review class
 * @method SuggestedReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuggestedReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuggestedReview[]    findAll()
 * @method SuggestedReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class SuggestedReviewRepository
 * @package App\Repository
 */
class SuggestedReviewRepository extends ServiceEntityRepository
{
    /**
     * SuggestedReviewRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SuggestedReview::class);
    }

    /**
     * removes the other suggestions with the same id when accepted or rejected
     * @param int $id
     */
    public function removeSuggestedItems($id)
    {
        $query = $this->createQueryBuilder('q')
            ->delete(SuggestedReview::class, 's')
            ->where('s.review =  ?1')
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
