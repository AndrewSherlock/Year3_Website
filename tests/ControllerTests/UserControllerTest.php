<?php


namespace App\Tests\ControllerTests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


class UserControllerTest  extends WebTestCase
{

    public function testUserHome()
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
        $crawler =$client->followRedirect();

        $client->request('GET', '/user/');
        $content = $client->getResponse()->getContent();

        $statusCode = $client->getResponse()->getStatusCode();

        $this->assertSame(Response::HTTP_OK, $statusCode);
        $this->assertContains(
            strtolower('User index'),
            strtolower($content)
        );
    }

    public function testProfilePage()
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
        $crawler =$client->followRedirect();


        $linkText = 'Profile';
        $link = $crawler->selectLink($linkText)->link();
        $client->click($link);

        $statusCode = $client->getResponse()->getStatusCode();

        // Assert
        $this->assertSame(Response::HTTP_OK, $statusCode);
        $this->assertContains(
            strtolower('ID number'),
            strtolower($client->getResponse()->getContent())
        );
    }

    public function testEditProfilePage()
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
        $crawler =$client->followRedirect();
        $client->followRedirects(true);
        $client->request('GET', '/user/2528/edit');

        $statusCode = $client->getResponse()->getStatusCode();

        $this->assertSame(Response::HTTP_OK, $statusCode);
        $this->assertContains(
            strtolower('Password'),
            strtolower($client->getResponse()->getContent())
        );
    }

    public function testEditFormWithAdmin()
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
        $crawler =$client->followRedirect();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/user/2588/edit');

        $editButtonName = 'Edit';
        $editButton = $crawler->selectButton($editButtonName);
        $editForm = $editButton->form();

        $this->assertNotNull($editForm);

        $editForm['user[username]'] = 'Testing user';
        $editForm['user[password]'] = 'Testing user';
        $client->submit($editForm);



        $content = $client->getResponse()->getContent();
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('user list', strtolower($content));

    }

    public function testEditSameUser()
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
        $crawler =$client->followRedirect();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/user/2529/edit');

        $editButtonName = 'Edit';
        $editButton = $crawler->selectButton($editButtonName);
        $editForm = $editButton->form();

        $this->assertNotNull($editForm);

        $editForm['user[username]'] = 'reg_user';
        $editForm['user[password]'] = password_hash('password', PASSWORD_BCRYPT);
        $client->submit($editForm);



        $content = $client->getResponse()->getContent();
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('edit user', strtolower($content));
    }

    public function testShowWithNull()
    {
        $url = '/user/2528';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();

        $this->assertContains('login', strtolower($content));
    }

    public function testShowRegUser()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'reg_user';
        $form['form[password]'] ='password';
        $client->submit($form);
        $crawler =$client->followRedirects(true);

        $url = '/user/2528';
        $crawler = $client->request($httpMethod, $url);
        $content = $client->getResponse()->getContent();

        $this->assertContains(
            strtolower('You do not have the access to do this'),
            strtolower($content)
        );
    }

    public function testNewUser()
    {
        $url = '/user/new';
        $httpMethod = 'GET';
        $client = static::createClient();

        $data = [
            'username' => 'testing user',
            'password' => 'password',
        ];

        $client->getRequest()->setSession(new Session());
        $client->getRequest()->getSession()->set('data', $data);
        $client->request($httpMethod, $url);

        $statusCode = $client->getResponse()->getStatusCode();
        //$client->followRedirect();

        $content = $client->getResponse()->getContent();

        $this->assertSame(Response::HTTP_OK, $statusCode);
        $this->assertContains(
            strtolower('User successfully created'),
            strtolower($content)
        );

    }

//    /**
//     * @dataProvider userLinks
//     * @param $url
//     * @param $expected
//     */
//    public function testPages($url, $expected)
//    {
//        // Logging in
//        $url = '/login';
//        $httpMethod = 'GET';
//        $client = static::createClient();
//
//        $crawler = $client->request($httpMethod, $url);
//        $buttonName = 'form[login]';
//        $button = $crawler->selectButton($buttonName);
//        $form = $button->form();
//        $form['form[username]'] = 'admin';
//        $form['form[password]'] = 'admin';
//        $crawler = $client->submit($form);
//        $client->followRedirect();
//
//        // show, edit
//
//        $crawler = $client->request($httpMethod, $url);
//
//
//        $statusCode = $client->getResponse()->getStatusCode();
//
//        // Assert
//        $this->assertSame(Response::HTTP_OK, $statusCode);
//        $this->assertContains(
//            strtolower($expected),
//            strtolower($client->getResponse()->getContent())
//        );
//    }

    public function userLinks()
    {
        return[
            [
                'user/2528/edit',
                'Edit User'
            ],
            [
                'user/2528',
                'ID number'
            ]
        ];
    }
}