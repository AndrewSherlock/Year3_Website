<?php
/**
 * Comment for file
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Food category
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * Class Category
 * @package App\Entity
 */
class Category
{
    /**
     * Category id
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * name of category
     * @ORM\Column(type="string")
     * @var string
     */
    private $category;


    /**
     * food list in category
     * @ORM\OneToMany(targetEntity="App\Entity\Food", mappedBy="category")
     * @var Food
     */
    private $foods;


    /**
     * gets the id of the category
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set the id
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * get the name of the category
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * sets the name of the category
     * @param string $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }
}
