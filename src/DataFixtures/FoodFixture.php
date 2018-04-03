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
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class FoodFixture  extends Fixture
{

    private $users = [];

    public function load(ObjectManager $manager)
    {
        $this->users = $manager->getRepository(User::class)->findAll();
        $manager->persist($this->franksIceCream($manager));
        $manager->flush();
        $manager->persist($this->freeistChoc($manager));
        $manager->flush();
        $manager->persist($this->freeistWhiteChoc($manager));
        $manager->flush();
        $manager->persist($this->freeistChocCookie($manager));
        $manager->flush();
        $manager->persist($this->freeistChocDark($manager));
        $manager->flush();
        $manager->persist($this->freeistJam($manager));
        $manager->flush();
        $manager->persist($this->freeistMarsh($manager));
        $manager->flush();
        $manager->persist($this->freeistPeanut($manager));
        $manager->flush();
        $manager->persist($this->freeistPop($manager));
        $manager->flush();
        $manager->persist($this->pepsiMax($manager));
        $manager->flush();
        $manager->persist($this->pepsiMaxCherry($manager));
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

        $photos = '{/images/foods/franks_ice.jpg}';
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Ice-cream']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

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

        $photos = '{/images/foods/freeist_choc.jpg}';
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Chocolate']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

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

        $photos = '{/images/foods/freeist_white.png}';
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Chocolate']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

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
        $food->setDateAdded(new \DateTime('now'));

        $photos = '{/images/foods/freeist_choc_cookie.jpg}';
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Biscuits']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

        return $food;

    }

    private function freeistChocDark(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Free\'ist Dark Chocolate 75G - Sugar Free');
        $food->setPrice(1.99);
        $food->setDescription('Here at Free\'ist HQ we believe that you don\'t need lots of sugar to have yummy tasting treats,
         so that\'s why we don\'t add sugar to any of our products. Our scrumptious range consists of sugar free and no added sugar treats, 
         that don\'t comprise on taste. Flavour is at the heart of everything we do so you can enjoy our great tasting snacks, without the guilt...
          We are Free\'ist, we are the most free!');

        $food->setSummary('Sugar Free Dark Chocolate with Sweetener');
        $food->setListOfIngredients('Sweetener (Maltitol), Cocoa Mass, Cocoa Butter, Inulin, Defatted Cocoa Powder, Emulsifier (Sunflower Lecithin), Natural Vanilla Flavour, Cocoa Solids 52% minimum');
        $food->setAddedBy($this->randomizeUser());
        $food->setDateAdded(new \DateTime('now'));

        $photos = '{/images/foods/freeist_dark.jpg}';
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Chocolate']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

        return $food;

    }

    private function freeistJam(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Free\'ist No Added Sugar Raspberry Jam 280g');
        $food->setPrice(3.19);
        $food->setDescription('Delicious and fruity, raspberry flavoured jam made 
        with naturally occurring sugar. Have for breakfast on toast or pancakes or enjoy in the evenings by adding to your dessert.');

        $food->setSummary('Free\'ist No Added Sugar Raspberry Jam 280g');
        $food->setListOfIngredients('Fruit content prepared with 117g fruit per 100g of which 102g Raspberry. With no added sugars, colours or flavours.
        Raspberries, raspberry juice (from concentrate), fruit juice (from grape concentrate), gelling agent (pectin, xanthan gum), preservative (potassium sorbate), sweetener (sucralose)');
        $food->setAddedBy($this->randomizeUser());
        $food->setDateAdded(new \DateTime('now'));

        $photos = '{/images/foods/freeist_jam.jpg}';
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Jam']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

        return $food;

    }

    private function freeistMarsh(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Free\'ist Sugar Free Marshmallows 75G');
        $food->setPrice(1.49);
        $food->setDescription('Sugar Free'.PHP_EOL.'Gluten Free'.PHP_EOL.'Fat Free, Dairy Free, &, Allergen Free'.PHP_EOL.'Can use for baking'.PHP_EOL.'
        Free\'ist indulges your craving for the little treats you love, without letting sugar get in the way but unlike other sugar free brands, we put flavour first!');

        $food->setSummary('Sugar Free Marshmallows with Sweeteners');
        $food->setListOfIngredients('Sweeteners: Maltitol Syrup, Isomalt, Steviol Glycosides, Water, Gelatine, Maize Starch, Natural Vanilla Flavouring, Acid: Lactic Acid, Colour E162');
        $food->setAddedBy($this->randomizeUser());
        $food->setDateAdded(new \DateTime('now'));

        $photos = '{/images/foods/freeist_marsh.png}';
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Sweets']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

        return $food;

    }

    private function freeistPeanut(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Free\'ist Chocolate Peanut Cookies 150G');
        $food->setPrice(1.99);
        $food->setDescription('Here at Free\'ist HQ we believe that you don\'t need lots of sugar to have yummy tasting treats, 
        so that\'s why we don\'t add sugar to any of our products. Our scrumptious range consists of sugar free and no added sugar treats, 
        that don\'t compromise on taste. Flavour is at the heart of everything we do so you can enjoy our great tasting snacks, without the guilt...');

        $food->setSummary('Choc Striped Peanut Cookies with Sweetener');
        $food->setListOfIngredients('Wheat Flour, Peanuts 24%, Margarine (Palm Oil, Rapeseed Oil, Water, Emulsifier: Mono- and Diglycerides of Fatty Acids, Lecithins, Salt, Acidity Regulator: Citric Acid, Flavouring, Colour), Sweetener: Maltitol, Sugar-Free Chocolate 17% [Sweetener: Maltitol, Cocoa Mass, Emulsifier: Lecithins (from Soy), Low Fat Cocoa Powder, Flavouring], Whole Egg Pulp, Raising Agents: Sodium Carbonates, Diphosphates, Salt, Flavouring, Colour: Carotenes');
        $food->setAddedBy($this->randomizeUser());
        $food->setDateAdded(new \DateTime('now'));

        $photos = '{/images/foods/freeist_peanut.jpg}';
        $food->setPhotoLink($photos);
        $food->setIsPublic(false);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Biscuit']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

        return $food;

    }

    private function freeistPop(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Free\'ist Sugar Free Caramel Crunch Popcorn 130G');
        $food->setPrice(2.49);
        $food->setDescription('Handmade popped to perfection in Ireland'.PHP_EOL.'The Irish Food Awards Blasna hÉireann Gold 2015'.PHP_EOL.'
        Sugar wise'.PHP_EOL.'Sugar & gluten free'.PHP_EOL.'Suitable for vegetarians'.PHP_EOL.'Sugar free');

        $food->setSummary('Sugar Free Caramel Crunch Popcorn with Sweeteners');
        $food->setListOfIngredients('Sweetener Blend: (Maltitol Syrup, Isomalt) (61%), Popped Corn (29%), Butter Oil (5%) (Milk), Molasses, Salt, Raising Agent: Sodium Bicarbonate, Emulsifier: Lecithin (Soya), Sweetener: Sucralose');
        $food->setAddedBy($this->randomizeUser());
        $food->setDateAdded(new \DateTime('now'));

        $photos = '{/images/foods/freeist_pop.jpg}';
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Sweets']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

        return $food;

    }

       private function pepsiMax(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Pepsi Max');
        $food->setPrice(2.39);
        $food->setDescription('With a delicious zesty flavour, Pepsi Cola is one of the most popular soft drinks in the world. This drink is flavoursome without being overly sweet and is perfect for refreshing yourself. Pepsi Max has all the great flavour of Pepsi, but with none of the sugar. A delicious treat for people of all ages, these pack contains 24 330ml cans.');

        $food->setSummary('Deliciously refreshing Pepsi Max, Perfect for quenching your thirst');
        $food->setListOfIngredients('Carbonated Water, Colour (Caramel E150d), Sweeteners (Aspartame, Acesulfame K), Acids (Phosphoric Acid, Citric Acid), Flavourings (including Caffeine), Preservative (Potassium Sorbate)');
        $food->setAddedBy($this->randomizeUser());

        $food->setDateAdded(new \DateTime('now'));

        $photos = '{/images/foods/pepsi_max.png}';
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Drinks']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

        return $food;

    }

    private function pepsiMaxCherry(ObjectManager $manager)
    {
        $food = new Food();
        $food->setTitle('Pepsi Max Cherry');
        $food->setPrice(9.00);
        $food->setDescription('Pepsi Max Cherry is the genius combination of full-on cherry cola taste, but with none of the sugar. Maximum Cherry. No Sugar. Launched in 1993, Pepsi Max has been bringing sugar free refreshment to the next generation ever since.');
        $food->setSummary('Deliciously refreshing Pepsi Max Cherry, Perfect for quenching your thirst');
        $food->setListOfIngredients('Carbonated Water, Colour (Caramel E150d), Sweeteners (Aspartame, Acesulfame K), Flavourings (including Caffeine), Acids (Phosphoric Acid, Citric Acid), Preservative (Potassium Sorbate)');
        $food->setAddedBy($this->randomizeUser());

        $food->setDateAdded(new \DateTime('now'));
        $photos = '{/images/foods/pepsi_max_cherry.png}';
        $food->setPhotoLink($photos);

        $cat = $manager->getRepository(Category::class)->findOneBy(['category' => 'Drinks']);
        $food->setCategory($cat);
        $food->setIsPublic(false);

        return $food;

    }


    private function randomizeUser()
    {
        $rand = rand(0, (sizeof($this->users) - 1));
        return $this->users[$rand];
    }
}

