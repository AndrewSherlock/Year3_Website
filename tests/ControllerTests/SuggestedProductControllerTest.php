<?php

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;



class SuggestedProductControllerTest  extends WebTestCase
{
    public function testNewSuggestedProduct()
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

        $url = '/food/detail/158';
        $crawler = $client->request($httpMethod, $url);

        $linkText = 'Suggest Public food';
        $link = $crawler->selectLink($linkText)->link();
        $client->click($link);

        $expectedCode = 302;
        $this->assertSame($expectedCode, $client->getResponse()->getStatusCode());

        $content = $client->getResponse()->getContent();
        $this->assertContains('/detail/', strtolower($content));

    }
}