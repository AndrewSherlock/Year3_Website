<?php
/**
 * comment for file
 */
namespace App\Repository;

use App\Entity\Food;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 *  Repository for the foods
 * @method Food|null find($id, $lockMode = null, $lockVersion = null)
 * @method Food|null findOneBy(array $criteria, array $orderBy = null)
 * @method Food[]    findAll()
 * @method Food[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class FoodRepository
 * @package App\Repository
 */
class FoodRepository extends ServiceEntityRepository
{
    /**
     * FoodRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Food::class);
    }

    /**
     * sets the food as a public item
     * @param $id
     */
    public function setItemPublic($id)
    {
        $query = $this->createQueryBuilder('q')
            ->update(Food::class, 'f')
            ->set('f.isPublic', '?1')
            ->where('f.id =  ?2')
            ->setParameter(1, true)
            ->setParameter(2, $id)
            ->getQuery();

        $query->execute();
    }
    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('f')
            ->where('f.something = :value')->setParameter('value', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
