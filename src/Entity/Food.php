<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FoodRepository")
 */
class Food
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *  @ORM\Column(type="string")
     */
    private $title;

    /**
     *  @ORM\Column(type="text")
     */
    private $summary;

    /**
     *  @ORM\Column(type="string")
     */
    private $photoLink;

    /**
     *  @ORM\Column(type="text")
     */
    private $description;

    /**
     *  @ORM\Column(type="text")
     */
    private $listOfIngredients;

    /**
     *  @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="foods")
     * @ORM\JoinColumn(nullable=true)
     */
    private $addedBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="foods")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="reviews")
     * @ORM\JoinColumn(nullable=true)
     */
    private $reviews;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SuggestedProduct", mappedBy="suggestProducts")
     * @ORM\JoinColumn(nullable=true)
     */
    private $suggestedProduct;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublic;


    /**
     * @return mixed
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @param mixed $reviews
     */
    public function setReviews($reviews): void
    {
        $this->reviews = $reviews;
    }

    /**
     *  @ORM\Column(type="date")
     */
    private $dateAdded;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
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
    public function getPhotoLink()
    {
        return $this->photoLink;
    }

    /**
     * @param mixed $photoLink
     */
    public function setPhotoLink($photoLink): void
    {
        $this->photoLink = $photoLink;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
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
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param mixed $dateAdded
     */
    public function setDateAdded($dateAdded): void
    {
        $this->dateAdded = $dateAdded;
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
    public function getListOfIngredients()
    {
        return $this->listOfIngredients;
    }

    /**
     * @param mixed $listOfIngredients
     */
    public function setListOfIngredients($listOfIngredients): void
    {
        $this->listOfIngredients = $listOfIngredients;
    }

    /**
     * @return mixed
     */
    public function getSuggestedProduct()
    {
        return $this->suggestedProduct;
    }

    /**
     * @param mixed $suggestedProduct
     */
    public function setSuggestedProduct($suggestedProduct): void
    {
        $this->suggestedProduct = $suggestedProduct;
    }



}
