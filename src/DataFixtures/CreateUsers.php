<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;



class CreateUsers extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword(password_hash('admin', PASSWORD_BCRYPT));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
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