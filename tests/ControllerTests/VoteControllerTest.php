<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 05/04/2018
 * Time: 16:39
 */

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class VoteControllerTest extends WebTestCase
{
    public function testNewVote()
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

        $crawler = $client->request($httpMethod, '/food/detail/155');
        $linkText = 'Upvote';

        $link = $crawler->selectLink($linkText)->link();
        $client->click($link);

        $content = $client->getResponse()->getContent();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('franks diabetic ice cream', strtolower($content));
    }

    public function testNewVoteWithConflict()
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

        $crawler = $client->request($httpMethod, '/food/detail/155');
        $linkText = 'Upvote';

        $link = $crawler->selectLink($linkText)->link();
        $client->click($link);

        $content = $client->getResponse()->getContent();

        $this->assertContains('you can not vote twice', strtolower($content));
    }
}