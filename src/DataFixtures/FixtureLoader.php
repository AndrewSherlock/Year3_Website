<?php
/**
 *  comment for file
 */
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 *  load the fixtures
 * Class FixtureLoader
 * @package App\DataFixtures
 */
class FixtureLoader extends Fixture implements DependentFixtureInterface
{
    /**
     * Not used function
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
    }

    /**
     * use for timing the fixtures
     * @return array
     */
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