<?php

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerTest extends WebTestCase
{
    /**
     * @dataProvider adminPagesProvider
     */
    public function testAdminPages($testUrl, $expectedText)
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

        $client->request($httpMethod, $testUrl);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();

        $this->assertContains(strtolower($expectedText), strtolower($content));
    }

    public function adminPagesProvider()
    {
        return [
            ['/admin','admin panel'],
            ['/admin/userList','User list'],
            ['/admin/foodList','Food list'],
            ['/admin/approveList','Suggested public food list'],
            ['/admin/approve_review_list','Suggested public list'],
            ['/admin/category_list','Category list']
        ];
    }

    public function testPromoteUser()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);


        $url = '/admin/promote/2529';
        $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('user account updated', strtolower($content));

    }

    public function testdemoteUser()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);


        $url = '/admin/demote/2529';
        $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('user account updated', strtolower($content));

    }

    public function testAcceptPublic()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);


        $url = '/admin/accept_public/122';
        $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('food list', strtolower($content));
    }

    public function testRejectPublic()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);


        $url = '/admin/reject_public/123';
        $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('food list', strtolower($content));
    }

    public function testAcceptPublicReview()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);


        $url = '/admin/accept_public_review/122';
        $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('food list', strtolower($content));
    }

    public function testRejectPublicReview()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);


        $url = '/admin/reject_public_review/123';
        $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('food list', strtolower($content));
    }

    public function testAdminDelete()
    {
        $url = '/login';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);


        $url = '/admin/delete/2550';
        $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('user list', strtolower($content));
    }
}

///reject_public/