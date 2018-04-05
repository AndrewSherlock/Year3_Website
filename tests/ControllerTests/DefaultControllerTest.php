<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 03/04/2018
 * Time: 20:17
 */

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{

    /**
     * @dataProvider pageTestsProvider
     */
    public function testPagesAreReachable($url, $searchText)
    {
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->request($httpMethod, $url);

        $statusCode = $client->getResponse()->getStatusCode();

        // Assert
        $this->assertSame(Response::HTTP_OK, $statusCode);
        $this->assertContains(
            strtolower($searchText),
            strtolower($client->getResponse()->getContent())
        );
    }

    public function pageTestsProvider()
    {
        return[
             [
                '/',
                'Welcome' // FAILING
            ],
            [
                '/register',
                'Register'
            ],
            [
                '/login',
                'Log in page'
            ]
        ];
    }

    public function testLoginWithValidInformation()
    {
        // Arrange
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';


        //act
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();

        $this->assertNotNull($form);

        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';

        $crawler = $client->submit($form);
        $expectedUrl = '/';
        $expectedText = 'logout';

        $this->assertContains($expectedUrl, $client->getResponse()->getContent());

        $crawler = $client->followRedirect();
        $content = $client->getResponse()->getContent();
        $this->assertContains(strtolower($expectedText), strtolower($content));
    }

    public function testLogout()
    {
        // Arrange
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';


        //act
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';

        $crawler = $client->submit($form);

        $crawler = $client->followRedirect();
       // $crawler = $client->getRequest();

        $linkText = 'Log out';
        $link = $crawler->selectLink($linkText)->link();
        $client->click($link);

        // TEST logout functions
        $linkCrawler = $client->followRedirect();
        $this->assertContains('/', $client->getResponse()->getContent());

        $content = $client->getResponse()->getContent();
        $expectedText = 'log in';



        $this->assertContains(strtolower($expectedText), strtolower($content));
    }

//    public function testNewUserSignup()
//    {
//        // Arrange
//        $url = '/login';
//        $httpMethod = 'GET';
//        $client = static::createClient();
//        $crawler = $client->request($httpMethod, $url);
//        $buttonName = 'form[login]';
//
//        //act
//        $button = $crawler->selectButton($buttonName);
//        $form = $button->form();
//
//        $form['form[username]'] = 'test user';
//
//        $crawler = $client->submit($form);
//        $expectedText = 'user created successfully';
//
//        $crawler = $client->followRedirect();
//        $content = $client->getResponse()->getContent();
//        $this->assertContains(strtolower($expectedText), strtolower($content));
//
//    }

}