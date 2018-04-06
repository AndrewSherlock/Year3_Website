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
        $client->submit($form);
        $client->followRedirect();

        $url = '/logout';
        $client->request($httpMethod, $url);
        $expectedCode = 302;
        $this->assertSame($expectedCode, $client->getResponse()->getStatusCode());


        $content = $client->getResponse()->getContent();
        $expectedText = 'redirect';
        $this->assertEmpty($client->getRequest()->getSession());
        $this->assertContains(strtolower($expectedText), strtolower($content));
    }

    public function testUserLoggedAttemptToRegister()
    {
        // Arrange
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $client->followRedirects(true);

        //act
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $crawler = $client->submit($form);


        $url = '/register';
        $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('you cannot do this while logged in', strtolower($content));


    }

    public function testNewUserSignup()
    {
        // Arrange
        $url = '/register';
        $httpMethod = 'GET';
        $client = static::createClient();
        $crawler = $client->request($httpMethod, $url);
        $client->followRedirects(true);

        $buttonName = 'form[login]';

        //act
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
//
//        $values = array(
//            'form[username]' => 'test user',
//            'form[password]' => [
//                'first' => 'password',
//                'second' => 'password'
//            ]
//        );

      //  $form->setValues($values);
       // $client->request($form->getMethod(), $form->getUri(), $values);


        $form['form[username]'] = 'test user';
        $form['form[password][first]'] = 'password';
        $form['form[password][second]'] = 'password';

        $crawler = $client->submit($form);
        $expectedText = 'user successfully created';

        $content = $client->getResponse()->getContent();
        $this->assertContains(strtolower($expectedText), strtolower($content));

    }
}