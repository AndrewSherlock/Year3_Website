<?php

use App\Entity\Food;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\SuggestedProduct;
use App\Entity\Review;
use App\Entity\Vote;

use PHPUnit\Framework\TestCase;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class FoodTest extends TestCase
{
    private function getArrayReviews($food, $user)
    {
        $review = new Review();
        $review->setFood($food);
        $review->setAddedBy($user);
        $review->setIsPublic(0);
        $review->setPrice(2);
        $review->setReviewScore(0);
        $review->setSummary('test summary');
        $review->setStars(3);
        $review->setPlaceOfPurchase('test place');
        $review->setDate(new DateTime('2001-01-10'));
        $review->setSuggestedReview(null);

        $vote = new Vote();
        $vote->setReview($review);
        $vote->setVoteType(-1);
        $vote->setUser($user);

        $review->setVotes($vote);

        return $review;
    }

    private function getTestUser()
    {
        $user = new User();
        $user->setUsername('paul');
        $user->setPassword('password');
        $user->setId('0');
        $user->setRoles(['ROLE_TESTER']);

        return $user;
    }

    private function getTestCat()
    {
        $cat = new Category();
        $cat->setId(0);
        $cat->setCategory('test cat');
        return $cat;
    }

    private function getTestSuggestedProduct($food)
    {
        $suggestedProduct = new SuggestedProduct();
        $suggestedProduct->setFood($food);

        return $suggestedProduct;
    }

    public function createTestObject()
    {
        $user = $this->getTestUser();

        $food = new Food();
        $food->setTitle('test food');
        $food->setSummary('test summary');
        $food->setDateAdded(new DateTime('2000-01-01'));
        $food->setDescription('test desc');
        $food->setPhotoLink('test image');
        $food->setPrice(3);
        $food->setSuggestedProduct($this->getTestSuggestedProduct($food));
        $food->setIsPublic(0);
        $food->setAddedBy($user);
        $food->setCategory($this->getTestCat());
        $food->setListOfIngredients('test ingredients');
        $food->setReviews($this->getArrayReviews($food, $user));

        return $food;
    }

    public function testFood()
    {
        $food = $this->createTestObject();

        $this->assertNotNull($food);

        $this->assertNull($food->getId());
        $this->assertNotEquals('0', $food->getId());

        $this->assertNotNull($food->getTitle());
        $this->assertEquals('test food', $food->getTitle());

        $this->assertNotNull($food->getSummary());
        $this->assertEquals('test summary', $food->getSummary());

        $this->assertNotNull($food->getDateAdded());
        $this->assertEquals(new DateTime('2000-01-01'), $food->getDateAdded());

        $this->assertNotNull($food->getDescription());
        $this->assertEquals('test desc', $food->getDescription());

        $this->assertNotNull($food->getPhotoLink());
        $this->assertEquals('test image', $food->getPhotoLink());

        $this->assertNotNull($food->getPrice());
        $this->assertEquals(3, $food->getPrice());

        $this->assertNotNull($food->getSuggestedProduct());
        $this->assertEquals($this->getTestSuggestedProduct($food), $food->getSuggestedProduct());

        $this->assertNotNull($food->getisPublic());
        $this->assertEquals(0, $food->getisPublic());

        $this->assertNotNull($food->getAddedBy());
        $this->assertEquals('paul', $food->getAddedBy()->getUsername());

        $this->assertNotNull($food->getCategory());
        $this->assertNotNull($food->getCategory()->getId());
        $this->assertEquals('test cat', $food->getCategory()->getCategory());

        $this->assertNotNull($food->getListOfIngredients());
        $this->assertEquals('test ingredients', $food->getListOfIngredients());

        $this->assertNotNull($food->getReviews());

    }

    public function testReview()
    {
        $review = $this->createTestObject()->getReviews();

        $this->assertNull($review->getId());

        $this->assertEquals('test summary', $review->getSummary());
        $this->assertNotNull($review->getFood());

        $this->assertNotNull($review->getAddedBy());

        $this->assertNotNull($review->getIsPublic());
        $this->assertEquals(0, $review->getIsPublic());

        $this->assertNotNull($review->getPrice());
        $this->assertEquals(2, $review->getPrice());

        $this->assertNotNull($review->getReviewScore());
        $this->assertEquals(0, $review->getReviewScore());

        $this->assertNotNull($review->getSummary());
        $this->assertEquals('test summary', $review->getSummary());

        $this->assertNotNull($review->getStars());
        $this->assertEquals(3, $review->getStars());

        $this->assertNotNull($review->getPlaceOfPurchase());
        $this->assertEquals('test place', $review->getPlaceOfPurchase());

        $this->assertNotNull( $review->getDate());
        $this->assertEquals(new DateTime('2001-01-10'), $review->getDate());

        $this->assertNotNull($review->getVotes());

        $this->assertNull($review->getSuggestedReview());
    }

    public function testVote()
    {
        $vote = $this->createTestObject()->getReviews()->getVotes();

        $this->assertNotNull($vote);

        $this->assertNull($vote->getId());
        $this->assertNotNull($vote->getReview());
        $this->assertNotNull($vote->getVoteType());
        $this->assertEquals('-1', $vote->getVoteType());

        $this->assertNotNull($vote->getUser());

    }

    public function testSuggestedProduct()
    {
        $suggested = $this->createTestObject()->getSuggestedProduct();

        $this->assertNull($suggested->getId());

        $this->assertNotNull($suggested->getFood());
    }

}