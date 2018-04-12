<?php

namespace App\Tests\ControllerTests;

use App\Controller\FoodController;
use App\Entity\Category;
use App\Entity\Food;
use App\Repository\CategoryRepository;
use App\Utils\ImageUploader;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FoodControllerTest  extends WebTestCase
{
    public function testFoodIndexLoggedIn()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);
        $client->followRedirect();

        $url = '/food/';
        $crawler = $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('sugar free foods', strtolower($content));
    }

    public function testIndexNotLoggedIn()
    {
        $url = '/food/';
        $httpMethod = 'GET';
        $client = static::createClient();
        $crawler = $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('sugar free foods', strtolower($content));
    }

    public function testFoodListForUser()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);
        $client->followRedirect();

        $url = '/food/user/206';
        $crawler = $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('food list', strtolower($content));
    }

    public function testShowDetailActionPublic()
    {
        $url = '/food/detail/155';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('franks diabetic ice cream', strtolower($content));
    }

    public function testShowDetailActionNotLogged()
    {
        $url = '/food/detail/156';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('access not granted', strtolower($content));
    }

    public function testEditFood()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);
        $client->followRedirects(true);

        $url = '/food/155/edit';
        $crawler = $client->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $buttonName = 'Edit';
        $button = $crawler->selectButton($buttonName);
        $editForm = $button->form();

        $editForm['food[photoLink]'][0]->upload(new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', '873625426_a7baa1334b_o.jpg', 'image/jpeg', 85890));

        $client->submit($editForm);

        $content = $client->getResponse()->getContent();
        $this->assertNotNull($editForm);

        $this->assertContains('122', strtolower($content));

    }

    public function testEditNotLoggedIn()
    {
        $url = '/food/155/edit';
        $httpMethod = 'GET';
        $client = static::createClient();
        $crawler = $client->request($httpMethod, $url);
       // $client->followRedirect();

        $content = $client->getResponse()->getContent();
        $this->assertContains('you must be logged in for that', strtolower($content));
    }

    public function testEditFoodReg()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'reg_user';
        $form['form[password]'] = 'password';
        $client->submit($form);
        $client->followRedirects(true);

        $url = '/food/155/edit';
        $crawler = $client->request($httpMethod, $url);
        $content = $client->getResponse()->getContent();

        $this->assertContains('you do not have access to do that', strtolower($content));
    }

    public function testFoodSearchText()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'reg_user';
        $form['form[password]'] = 'password';
        $client->submit($form);

        $url = '/food/';
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'Search_foods';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();

        $form['text_search'] = 'white';
        $client->submit($form);

        $this->assertNotNull($form);

        $content = $client->getResponse()->getContent();
        $this->assertContains('white', strtolower($content));
    }

    public function testFoodSearchDate()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'reg_user';
        $form['form[password]'] = 'password';
        $client->submit($form);

        $url = '/food/';
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'Search foods';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();

        $form['date_search'] = '2018-04-03';
        $client->submit($form);

        $this->assertNotNull($form);

        $content = $client->getResponse()->getContent();
        $this->assertContains('white', strtolower($content));

    }

    public function testFoodSearchPriceRange()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'reg_user';
        $form['form[password]'] = 'password';
        $client->submit($form);

        $url = '/food/';
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'Search foods';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();

        $form['price_range'] = '1';
        $client->submit($form);

        $this->assertNotNull($form);

        $content = $client->getResponse()->getContent();
        $this->assertContains('white', strtolower($content));

    }

    public function testFoodSearchAll()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'reg_user';
        $form['form[password]'] = 'password';
        $client->submit($form);

        $url = '/food/';
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'Search foods';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();

        $form['text_search'] = 'white';
        $form['date_search'] = '2018-04-03';
        $form['price_range'] = '1';
        $client->submit($form);

        $this->assertNotNull($form);

        $content = $client->getResponse()->getContent();
        $this->assertContains('white', strtolower($content));

    }

    /**
     * @dataProvider rangeGetter
     */
    public function testFoodSearchWithPriceProd($range, $expected)
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'reg_user';
        $form['form[password]'] = 'password';
        $client->submit($form);

        $url = '/food/';
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'Search foods';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();

        $form['price_range'] = $range;
        $client->submit($form);

        $content = $client->getResponse()->getContent();
        $this->assertContains($expected, strtolower($content));
    }

    public function rangeGetter()
    {
        return [
            [0,'sugar free foods'],
            [1,'sugar free foods'],
            [2,'sugar free foods'],
            [3,'sugar free foods']
        ];
    }

    public function testNewFood()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'reg_user';
        $form['form[password]'] = 'password';
        $client->submit($form);
        $client->followRedirects(true);

        $url = '/food/new';
        $crawler = $client->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();
        $this->assertContains('create new food', strtolower($content));


        $buttonName = 'Save';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();

        $this->assertNotNull($form);

        $category = new Category();
        $categoryRepo = $this->createMock(ObjectManager::class);
        $categoryRepo->method('find')->willReturn($category);

        $file = new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', '873625426_a7baa1334b_o.jpg', 'image/jpeg', 85890);


        $form['food[title]'] = 'Testing food';
        $form['food[summary]'] = 'test summary';
        $form['food[photoLink]'][0]->upload($file);
        $form['food[description]'] = 'test description';
        $form['food[listOfIngredients]'] = 'test ingredents';
        $form['food[price]'] = '3';
        $form['food[category]'] = '171';

        //$client->getRequest()->files->set('food[photolink]', new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', 'test.jpg', 'image/jpg', 10000000));
        $client->submit($form);

        $content = $client->getResponse()->getContent();
        $this->assertContains('sugar free foods', strtolower($content));

    }

    public function testNewNotLoggedIn()
    {
        $httpMethod = 'GET';
        $url = '/food/new';
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();

        $this->assertContains('you must be logged in for this action', strtolower($content));
    }

    public function testNewFailingImage()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'reg_user';
        $form['form[password]'] = 'password';
        $client->submit($form);
        $client->followRedirects(true);

        $url = '/food/new';
        $crawler = $client->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();


        $buttonName = 'Save';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();

        $this->assertNotNull($form);

        $category = new Category();
        $categoryRepo = $this->createMock(ObjectManager::class);
        $categoryRepo->method('find')->willReturn($category);

        $form['food[title]'] = 'Testing food';
        $form['food[summary]'] = 'test summary';
        $form['food[photoLink]'][0]->upload(new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', '873625426_a7baa1334b_o.jpg', 'image/jpeg', 85890));
        $form['food[description]'] = 'test description';
        $form['food[listOfIngredients]'] = 'test ingredents';
        $form['food[price]'] = '3';
        $form['food[category]'] = '171';

        //$client->getRequest()->files->set('food[photolink]', new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', 'test.jpg', 'image/jpg', 10000000));
        $client->submit($form);

        $content = $client->getResponse()->getContent();
        $this->assertContains('there was a probelm with your images', strtolower($content));
    }

    public function testDeleteOption()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);
        $client->followRedirects(true);

        $url = 'food/delete/161';
        $crawler = $client->request($httpMethod, $url);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();

        $this->assertContains('sugar free foods',strtolower($content));

    }

}