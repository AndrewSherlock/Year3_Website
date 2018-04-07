<?php

/**
 *  comment for the file
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *  class for suggested reviews to be made public
 * @ORM\Entity(repositoryClass="App\Repository\SuggestedReviewRepository")
 * Class SuggestedReview
 * @package App\Entity
 */
class SuggestedReview
{
    /**
     *  Id for the suggestion
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * The review that this is assocaited with
     * @ORM\ManyToOne(targetEntity="App\Entity\Review", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=true)
     * @var Review
     */
    private $review;

    /**
     * get the id for this suggestion
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get the review assocaited with this class
     * @return Review
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     *  sets the review this is assocatied with
     * @param Review $review
     */
    public function setReview($review): void
    {
        $this->review = $review;
    }
}
