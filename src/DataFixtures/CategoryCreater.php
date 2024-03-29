<?php
/**
 * comment for the file
 */
namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


/**
 *  Fixture class for category
 * Class CategoryCreater
 * @package App\DataFixtures
 */
class CategoryCreater extends Fixture
{
    /**
     * load the categorys
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $cat_1 = new Category();
        $cat_1->setCategory('Sweets');
        $manager->persist($cat_1);
        $manager->flush();

        $cat_2 = new Category();
        $cat_2->setCategory('Drinks');
        $manager->persist($cat_2);
        $manager->flush();

        $cat_3 = new Category();
        $cat_3->setCategory('Biscuits');
        $manager->persist($cat_3);
        $manager->flush();

        $cat_3 = new Category();
        $cat_3->setCategory('Chocolate');
        $manager->persist($cat_3);
        $manager->flush();

        $cat_4 = new Category();
        $cat_4->setCategory('Ice-cream');
        $manager->persist($cat_4);
        $manager->flush();

        $cat_5 = new Category();
        $cat_5->setCategory('Jam');
        $manager->persist($cat_5);
        $manager->flush();

    }
}