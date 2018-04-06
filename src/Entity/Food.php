<?php
/**
 * comment for the file
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\MakerBundle\Str;

/**
 * the food object that is on site
 * @ORM\Entity(repositoryClass="App\Repository\FoodRepository")
 * Class Food
 * @package App\Entity
 */
class Food
{
    /**
     * Id of food object
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int $id
     */
    private $id;

    /**
     * Title of the food
     *  @ORM\Column(type="string")
     * @var string
     */
    private $title;

    /**
     * summary of the food
     *  @ORM\Column(type="text")
     * @var string
     */
    private $summary;

    /**
     * The photos of the food
     *  @ORM\Column(type="string")
     * @var string
     */
    private $photoLink;

    /**
     * description of food
     *  @ORM\Column(type="text")
     * @var string
     */
    private $description;

    /**
     *  ingrendients of food
     *  @ORM\Column(type="text")
     * @var string
     */
    private $listOfIngredients;

    /**
     *  price of food
     *  @ORM\Column(type="decimal")
     * @var float
     */
    private $price;

    /**
     * The user that added the food
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="foods")
     * @ORM\JoinColumn(nullable=true)
     * @var User
     */
    private $addedBy;

    /**
     * Category of the food
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="foods")
     * @ORM\JoinColumn(nullable=true)
     * @var Category
     */
    private $category;

    /**
     * The reviews that are linked to the food
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="reviews")
     * @ORM\JoinColumn(nullable=true)
     * @var Review
     */
    private $reviews;

    /**
     * If the food is suggested to be public
     * @ORM\OneToMany(targetEntity="App\Entity\SuggestedProduct", mappedBy="suggestProducts")
     * @ORM\JoinColumn(nullable=true)
     * @var SuggestedProduct
     */
    private $suggestedProduct;

    /**
     * for use to make the item public
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $isPublic;


    /**
     * gets the reviews that are linked to the food
     * @return mixed
     * @return Review|ArrayCollection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * sets the reviews linked to object
     * @param Review $reviews
     */
    public function setReviews($reviews): void
    {
        $this->reviews = $reviews;
    }

    /**
     * Date of the food added
     *  @ORM\Column(type="date")
     * @var \DateTime
     */
    private $dateAdded;

    /**
     * Food constructor.
     */
    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    /**
     * gets the id of the food
     * @return mixed
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * gets the title of the food
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the name of the food
     * @param string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * gets the summary of the food
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * sets the summary of the food
     * @param string $summary
     */
    public function setSummary($summary): void
    {
        $this->summary = $summary;
    }

    /**
     * gets the photos links
     * @return string
     */
    public function getPhotoLink()
    {
        return $this->photoLink;
    }

    /**
     * sets the photo links
     * @param string $photoLink
     */
    public function setPhotoLink($photoLink): void
    {
        $this->photoLink = $photoLink;
    }

    /**
     * gets the  description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * sets the description
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * gets the price of the food
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * sets the price of the food
     * @param float $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * gets the user that added the food
     * @return User
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * sets teh user that created the food
     * @param User $addedBy
     */
    public function setAddedBy($addedBy): void
    {
        $this->addedBy = $addedBy;
    }

    /**
     * gets the category of the food
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * sets the category of the food
     * @param Category $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * gets the date the food was added to the site
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * sets the date of the food
     * @param \DateTime $dateAdded
     */
    public function setDateAdded($dateAdded): void
    {
        $this->dateAdded = $dateAdded;
    }

    /**
     * gets the food public state
     * @return boolean
     */
    public function getisPublic()
    {
        return $this->isPublic;
    }

    /**
     * sets the foods public state
     * @param boolean $isPublic
     */
    public function setIsPublic($isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    /**
     * gets the indregients of the food
     * @return string
     */
    public function getListOfIngredients()
    {
        return $this->listOfIngredients;
    }

    /**
     * sets the list of ingredients
     * @param string $listOfIngredients
     */
    public function setListOfIngredients($listOfIngredients): void
    {
        $this->listOfIngredients = $listOfIngredients;
    }

    /**
     * gets the list of times it was suggested to be public
     * @return SuggestedProduct
     */
    public function getSuggestedProduct()
    {
        return $this->suggestedProduct;
    }

    /**
     * sets the suggested products
     * @param SuggestedProduct $suggestedProduct
     */
    public function setSuggestedProduct($suggestedProduct): void
    {
        $this->suggestedProduct = $suggestedProduct;
    }
}
