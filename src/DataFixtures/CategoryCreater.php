<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;



class CategoryCreater extends Fixture
{
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

    }
}