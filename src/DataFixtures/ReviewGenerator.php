<?php
/**
 *  comment for the file
 */
namespace App\DataFixtures;

use App\Entity\Food;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


/**
 *  Generate the reviews for the food
 * Class ReviewGenerator
 * @package App\DataFixtures
 */
class ReviewGenerator extends Fixture
{
    /**
     * the users list
     * @var array
     */
    private $users = [];

    /**
     *  load the review fixtures
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $foods = $manager->getRepository(Food::class)->findAll();
        $this->users = $manager->getRepository(User::class)->findAll();
        $faker = \Faker\Factory::create();

        foreach ($foods as $food)
        {
            $numOfReviewsToGenerate = rand(0, 20);

            for($i = 0; $i < $numOfReviewsToGenerate; $i++)
            {
                $review = new Review();

                $review->setSummary($faker->realText(100,2));
                $review->setDate($faker->dateTime());
                $review->setPrice(rand($food->getPrice() - .50, $food->getPrice() + .50));
                $review->setPlaceOfPurchase($faker->name());
                $review->setFood($food);

                $numOfStars = rand(0,5);
                $review->setStars($numOfStars);
                $review->setReviewScore(0);
                $review->setIsPublic(false);
                $review->setAddedBy($this->randomizeUser());

                $manager->persist($review);
                $manager->flush();
            }
        }

    }

    /**
     *  get a random user for the review
     * @return User
     */
    private function randomizeUser()
    {
        $rand = rand(0, (sizeof($this->users) - 1));
        return $this->users[$rand];
    }
}