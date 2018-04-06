<?php

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerTest extends WebTestCase
{
    public function testAdminHome()
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

        $url = '/admin/';
        $crawler  = $client->request($httpMethod, $url);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();

        $this->assertContains('Admin Panel', strtolower($content));

    }
}