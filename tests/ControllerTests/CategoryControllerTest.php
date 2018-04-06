<?php

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class CategoryControllerTest extends WebTestCase
{
    public function testNewCategory()
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

        $url = '/admin/category_list';
        $crawler = $client->request($httpMethod, $url);

        $linkText = 'Add new category';
        $link = $crawler->selectLink($linkText)->link();
        $crawler = $client->click($link);
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $buttonName = 'Save';
        $button = $crawler->selectButton($buttonName);
        $catForm = $button->form();

        $catForm['category[category]'] = 'Test Category';
        $client->submit($catForm);

        $expectedCode = 302;
        $this->assertNotNull($catForm);
        $this->assertSame($expectedCode, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();
        $this->assertContains('category_list', strtolower($content));
    }

    public function testEditCategory()
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

        $url = '/category/134/edit';
        $crawler = $client->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $buttonName = 'Edit';
        $button = $crawler->selectButton($buttonName);
        $editFrom = $button->form();
        $this->assertNotNull($editFrom);

        $editFrom['category[category]'] = 'Sweets';
        $client->submit($editFrom);

        $expectedCode = 302;
        $content = $client->getResponse()->getContent();

        $this->assertSame($expectedCode, $client->getResponse()->getStatusCode());
        $this->assertContains('category_list', strtolower($content));
    }

    public function testDeleteCategory()
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

        $url = '/category/151/delete';
        $crawler = $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('category_list', strtolower($content));
    }


}