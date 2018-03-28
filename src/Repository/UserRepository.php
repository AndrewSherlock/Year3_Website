<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByUsername($username)
    {
        $u = $this->createQueryBuilder('u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getArrayResult();

        if($u != null)
            return $u[0];
        else
            return null;
    }
    public function changeUserAccount($id, $nAccount)
    {
        $json_array = [$nAccount];
        $arr = json_encode($json_array);

        $query = $this->createQueryBuilder('q')
            ->update(User::class, 'u')
            ->set('u.roles', '?1')
            ->where('u.id =  ?2')
            ->setParameter(1, $arr)
            ->setParameter(2, $id)
            ->getQuery();

        $query->execute();

    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.something = :value')->setParameter('value', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

}
