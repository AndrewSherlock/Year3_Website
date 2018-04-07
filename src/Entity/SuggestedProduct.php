<?php
/**
 * comment for the file
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * suggested product class used for suggested public foods
 * @ORM\Entity(repositoryClass="App\Repository\SuggestedProductRepository")
 * Class SuggestedProduct
 * @package App\Entity
 */
class SuggestedProduct
{
    /**
     *  id for the suggestion
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     *  the associated food object
     * @ORM\ManyToOne(targetEntity="App\Entity\Food", inversedBy="foods")
     * @ORM\JoinColumn(nullable=true)
     * @var Food
     */
    private $food;

    /**
     * gets the id of the suggested product class
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * gets the food assocaited suggestion
     * @return Food
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * sets the food
     * @param Food $food
     */
    public function setFood($food): void
    {
        $this->food = $food;
    }


}
