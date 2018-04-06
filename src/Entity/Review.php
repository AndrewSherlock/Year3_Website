<?php
/**
 * Comment for file
 */
namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Review class
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 * Class Review
 * @package App\Entity
 */
class Review
{
    /**
     * Id for review
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     *  User that added the reveiw
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=true)
     * @var User
     */
    private $addedBy;

    /**
     * Price the user paid
     * @ORM\Column(type="decimal")
     * @var float
     */
    private $price;

    /**
     * Review text
     * @ORM\Column(type="text")
     * @var string
     */
    private $summary;

    /**
     * the number of stars the review has given the food
     * @ORM\Column(type="float")
     * @var float
     */
    private $stars;

    /**
     * The date the review was added
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $date;

    /**
     * The votes associated with the review
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="Review")
     * @var Vote
     */
    private $votes;

    /**
     * The aggrated score the review
     * @ORM\Column(type="integer")
     * @var int
     */
    private $review_score;

    /**
     * The place of purchase
     * @ORM\Column(type="string")
     * @var string
     */
    private $placeOfPurchase;

    /**
     *  the public status of the review
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $isPublic;

    /**
     * The food that the review is associated with
     * @ORM\ManyToOne(targetEntity="App\Entity\Food", inversedBy="foods")
     * @ORM\JoinColumn(nullable=true)
     * @var Food
     */
    private $food;

    /**
     *  if the review is suggested to be public
     * @ORM\OneToMany(targetEntity="App\Entity\SuggestedReview", mappedBy="suggestedReview")
     * @ORM\JoinColumn(nullable=true)
     * @var  SuggestedReview
     */
    private $suggestedReview;

    /**
     *  get the total score of the review
     * @return int
     */
    public function getReviewScore()
    {
        return $this->review_score;
    }

    /**
     * set the score of the review
     * @param int $review_score
     */
    public function setReviewScore($review_score): void
    {
        $this->review_score = $review_score;
    }

    /**
     * get the date the review was added
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * set the date the review was added
     * @param \DateTime $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * the vote list associated with the review
     * @return Vote |Collection
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * set the votes to the Review
     * @param Vote $votes
     */
    public function setVotes($votes): void
    {
        $this->votes = $votes;
    }

    /**
     * get the id of the review
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get the user that added the review
     * @return User
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * set the user associated with the review
     * @param User $addedBy
     */
    public function setAddedBy($addedBy): void
    {
        $this->addedBy = $addedBy;
    }

    /**
     * get the price of the food
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * set the price of the food
     * @param float $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * get the review text
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * set the review text
     * @param string $summary
     */
    public function setSummary($summary): void
    {
        $this->summary = $summary;
    }

    /**
     * get the food score
     * @return float
     */
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * set the review score
     * @param float $stars
     */
    public function setStars($stars): void
    {
        $this->stars = $stars;
    }

    /**
     * get the food associated with the food
     * @return Food
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * set the food associated with the food
     * @param Food $food
     */
    public function setFood($food): void
    {
        $this->food = $food;
    }

    /**
     * get the public state of the review
     * @return boolean
     */
    public function getisPublic()
    {
        return $this->isPublic;
    }

    /**
     * set the public state of the food
     * @param boolean $isPublic
     */
    public function setIsPublic($isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    /**
     * get the review place of purchase
     * @return string
     */
    public function getPlaceOfPurchase()
    {
        return $this->placeOfPurchase;
    }

    /**
     * set the place of purchase
     * @param string $placeOfPurchase
     */
    public function setPlaceOfPurchase($placeOfPurchase): void
    {
        $this->placeOfPurchase = $placeOfPurchase;
    }

    /**
     * get the list of suggested reviews
     * @return SuggestedReview
     */
    public function getSuggestedReview()
    {
        return $this->suggestedReview;
    }

    /**
     * set the suggested reviews
     * @param SuggestedReview $suggestedReview
     */
    public function setSuggestedReview($suggestedReview): void
    {
        $this->suggestedReview = $suggestedReview;
    }

}
