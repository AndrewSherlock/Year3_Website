<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FixtureLoader extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
    }


    function getDependencies()
    {
        return array(
            CreateUsers::class,
            CategoryCreater::class,
            FoodFixture::class,
            ReviewGenerator::class
        );
    }

}