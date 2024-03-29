<?php
/**
 * comment for file
 */
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


/**
 *  users creation class
 * Class CreateUsers
 * @package App\DataFixtures
 */
class CreateUsers extends Fixture
{
    /**
     *  load users
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword(password_hash('admin', PASSWORD_BCRYPT));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();

        $reg_user = new User();
        $reg_user->setUsername('reg_user');
        $reg_user->setPassword(password_hash('password', PASSWORD_BCRYPT));
        $reg_user->setRoles(['ROLE_USER']);
        $manager->persist($reg_user);
        $manager->flush();

        for($i = 0; $i < 99; $i++)
        {
            $user = new User();
            $username = $faker->userName();

            $password = $faker->password();
            $user->setUsername($username);
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
        }
    }
}