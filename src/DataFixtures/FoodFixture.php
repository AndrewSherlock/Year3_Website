<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 03/04/2018
 * Time: 16:27
 */

namespace App\DataFixtures;


use App\Entity\Category;
use App\Entity\Food;
use Doctrine\Common\Persistence\ObjectManager;


class FoodFixture  extends Fixture
{

    private $users = [];

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $this->users = $manager->getRepository(User::class)->findAll();
        $manager->persist($this->franksIceCream($manager));
        $manager->flush();
        $manager->persist($this->freeistChoc($manager));
        $manager->flush();
        $manager->persist($this->freeistWhiteChoc($manager));
        $manager->flush();
        $manager->persist($this->freeistChocCookie($manager));
        $manager->flush();



    }

    private function franksIceCream(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Franks Diabetic Ice Cream');
        $food->setPrice(3.38);
        $food->setDescription('Frank\'s Ice Cream has been manufacturing premium ice cream for over 80 years and 
        has won numerous regional, national and international awards including the prestigious European and British cups. In addition, 
        Frank\'s won the coveted title \'Champion of Champions\' for \'Britain\'s best ice cream\'.No wonder Frank\'s is judged Britain\'s tastiest ice cream
        British and European Cup Winners'.PHP_EOL.'
        Contains non milk fat'.PHP_EOL.'
        Gluten free'.PHP_EOL.'
        Suitable for vegetarians');

        $food->setSummary('Franks Diabetic Vanilla Ice Cream 1 Litre');
        $food->setListOfIngredients('Reconstituted Skimmed Milk, Palm & Palm Kernel Oil, Fructose, Maltodextrin, Dextrose, Emulsifier: Mono- and 
        Diglycerides of Fatty Acids, Stabilisers: Locust Bean Gum, Guar Gum, Carrageenan, Flavouring, Natural Colour: Curcumin, Annatto');
        $food->setDateAdded(new \DateTime('now'));
        $food->setAddedBy($this->randomizeUser());

        $photos = ['{/images/foods/franks_ice.jpg}'];
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Ice-cream']);
        $food->setCategory($cat);

        return $food;

    }

    private function freeistChoc(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Free\'ist Milk Chocolate 75G - No Added Sugar');
        $food->setPrice(1.99);
        $food->setDescription('Here at Free\'ist HQ we believe that you don\'t need lots of sugar to have yummy tasting treats, 
        so that\'s why we don\'t add sugar to any of our products. Our scrumptious range consists of sugar free and no added sugar treats, 
        that don\'t compromise on taste. Flavour is at the heart of everything we do so you can enjoy our great tasting snacks, without the guilt....
        We are Free\'ist, we are the most free!');

        $food->setSummary('No Added Sugar & Gluten Free Milk Chocolate with Sweetener');
        $food->setListOfIngredients('Sweetener (Maltitol), Cocoa Butter, Whole Milk Powder (17%), Cocoa Mass, 
        Emulsifier (Sunflower Lecithin), Natural Vanilla Flavour, Cocoa Solids 34% minimum, Milk Solids 17% minimum');
        $food->setDateAdded(new \DateTime('now'));
        $food->setAddedBy($this->randomizeUser());

        $photos = ['{/images/foods/franks_choc.jpg}'];
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Chocolate']);
        $food->setCategory($cat);

        return $food;

    }

    private function freeistWhiteChoc(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Free\'ist White Strawberry Chocolate 75G - No Added Sugar');
        $food->setPrice(1.99);
        $food->setDescription('Here at Free\'ist HQ we believe that you don\'t need lots of sugar to have yummy tasting treats, 
        so that\'s why we don\'t add sugar to any of our products. Our scrumptious range consists of sugar free and no added sugar treats, 
        that don\'t compromise on taste. Flavour is at the heart of everything we do so you can enjoy our great tasting snacks, without the guilt....
        We are Free\'ist, we are the most free!');

        $food->setSummary('No Added Sugar & Gluten Free White Chocolate with Strawberries & with Sweetener');
        $food->setListOfIngredients('Sweetener (Maltitol), Cocoa Butter, Whole Milk Powder (19%), Inulin, Lyophilized Strawberry (2%), 
        Emulsifier (Sunflower Lecithin), Strawberry Flavour, Natural Vanilla Flavour, Cocoa Solids 27% minimum, Milk Solids 19% minimum');
        $food->setDateAdded(new \DateTime('now'));
        $food->setAddedBy($this->randomizeUser());

        $photos = ['{/images/foods/freeist_white.png}'];
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Chocolate']);
        $food->setCategory($cat);

        return $food;
    }

    private function freeistChocCookie(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Free\'ist White Strawberry Chocolate 75G - No Added Sugar');
        $food->setPrice(1.99);
        $food->setDescription('Here at Free\'ist HQ we believe that you don\'t need lots of sugar to have yummy tasting treats, 
        so that\'s why we don\'t add sugar to any of our products. Our scrumptious range consists of sugar free and no added sugar treats, 
        that don\'t compromise on taste. Flavour is at the heart of everything we do so you can enjoy our great tasting snacks, without the guilt...'.PHP_EOL.'
        No added sugar'.PHP_EOL.'Choc-full!'.PHP_EOL.'Sugar wise'.PHP_EOL.'No added sugar');

        $food->setSummary('Chocolate Chip Cookies with Sweetener');
        $food->setListOfIngredients('Wheat Flour, Sugar-Free Chocolate 37% [Sweetener: Maltitol, Cocoa Mass, Emulsifier: Lecithins (from Soy), 
        Low Fat Cocoa Powder, Flavouring], Palm Oil, Rapeseed Oil, Sweetener: Maltitol, Oat Flour, Skimmed Milk Powder, Raising Agent: Ammonium Carbonate, Salt, 
        Flavouring');
        $food->setAddedBy($this->randomizeUser());

        $photos = ['{/images/foods/freeist_choc_cookie.jpg}'];
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Biscuits']);
        $food->setCategory($cat);

        return $food;

    }

    private function freeistChocDark(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Free\'ist White Strawberry Chocolate 75G - No Added Sugar');
        $food->setPrice(1.99);
        $food->setDescription('Here at Free\'ist HQ we believe that you don\'t need lots of sugar to have yummy tasting treats, 
        so that\'s why we don\'t add sugar to any of our products. Our scrumptious range consists of sugar free and no added sugar treats, 
        that don\'t compromise on taste. Flavour is at the heart of everything we do so you can enjoy our great tasting snacks, without the guilt...'.PHP_EOL.'
        No added sugar'.PHP_EOL.'Choc-full!'.PHP_EOL.'Sugar wise'.PHP_EOL.'No added sugar');

        $food->setSummary('Chocolate Chip Cookies with Sweetener');
        $food->setListOfIngredients('Wheat Flour, Sugar-Free Chocolate 37% [Sweetener: Maltitol, Cocoa Mass, Emulsifier: Lecithins (from Soy), 
        Low Fat Cocoa Powder, Flavouring], Palm Oil, Rapeseed Oil, Sweetener: Maltitol, Oat Flour, Skimmed Milk Powder, Raising Agent: Ammonium Carbonate, Salt, 
        Flavouring');
        $food->setAddedBy($this->randomizeUser());

        $photos = ['{/images/foods/freeist_choc_cookie.jpg}'];
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Biscuits']);
        $food->setCategory($cat);

        return $food;

    }


    private function randomizeUser()
    {
        $rand = rand($this->users[0]->getId(), $this->users[sizeof($this->users)]->getId());
        return $this->users[$rand];
    }
}

