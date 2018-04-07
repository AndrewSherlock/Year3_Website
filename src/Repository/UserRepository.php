<?php
/**
 *  comment for the file
 */
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * User repository
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * gets the user by name
     * @param string $username
     * @return User
     */
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

    /**
     * changes the user role
     * @param int $id
     * @param string $nAccount
     */
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

    /**
     * gives the fixture all users
     * @return User[]
     */
    public function giveUsersToFixtures()
    {
        return $this->findAll();
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
