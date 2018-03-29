<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=true)
     */
    private $addedBy;

    /**
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $summary;

    /**
     * @ORM\Column(type="float")
     */
    private $stars;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="Review")
     */
    private $votes;

    /**
     * @ORM\Column(type="integer")
     */
    private $review_score;

    /**
     * @ORM\Column(type="string")
     */
    private $placeOfPurchase;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublic;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Food", inversedBy="foods")
     * @ORM\JoinColumn(nullable=true)
     */
    private $food;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SuggestedReview", mappedBy="suggestedReview")
     * @ORM\JoinColumn(nullable=true)
     */
    private $suggestedReview;

    /**
     * @return mixed
     */
    public function getReviewScore()
    {
        return $this->review_score;
    }

    /**
     * @param mixed $review_score
     */
    public function setReviewScore($review_score): void
    {
        $this->review_score = $review_score;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param mixed $votes
     */
    public function setVotes($votes): void
    {
        $this->votes = $votes;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * @param mixed $addedBy
     */
    public function setAddedBy($addedBy): void
    {
        $this->addedBy = $addedBy;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param mixed $summary
     */
    public function setSummary($summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * @param mixed $stars
     */
    public function setStars($stars): void
    {
        $this->stars = $stars;
    }

    /**
     * @return mixed
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * @param mixed $food
     */
    public function setFood($food): void
    {
        $this->food = $food;
    }

    /**
     * @return mixed
     */
    public function getisPublic()
    {
        return $this->isPublic;
    }

    /**
     * @param mixed $isPublic
     */
    public function setIsPublic($isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return mixed
     */
    public function getPlaceOfPurchase()
    {
        return $this->placeOfPurchase;
    }

    /**
     * @param mixed $placeOfPurchase
     */
    public function setPlaceOfPurchase($placeOfPurchase): void
    {
        $this->placeOfPurchase = $placeOfPurchase;
    }

    /**
     * @return mixed
     */
    public function getSuggestedReview()
    {
        return $this->suggestedReview;
    }

    /**
     * @param mixed $suggestedReview
     */
    public function setSuggestedReview($suggestedReview): void
    {
        $this->suggestedReview = $suggestedReview;
    }

}
