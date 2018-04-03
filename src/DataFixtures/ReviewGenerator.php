<?php

namespace App\DataFixtures;

use App\Entity\Food;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;



class ReviewGenerator extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $foods = $manager->getRepository(Food::class);
        $users = $manager->getRepository(User::class)->findAll();
        $faker = \Faker\Factory::create();

        foreach ($foods as $food)
        {
            $numOfReviewsToGenerate = rand(0, 20);

            for($i = 0; i < $numOfReviewsToGenerate; $i++)
            {
                $review = new Review();

                $review->setSummary($faker->realText(100,2));
                $review->setDate(new \DateTime($faker->dateTime()));
                $review->setPrice(rand($food->getPrice() - .50, $food->getPrice() + .50));
                $review->setPlaceOfPurchase($faker->name());
                $review->setFood($food);

                $numOfStars = rand(0,5);
                $review->setStars($numOfStars);

                $manager->persist($review);
                $manager->flush();
            }
        }

    }
}