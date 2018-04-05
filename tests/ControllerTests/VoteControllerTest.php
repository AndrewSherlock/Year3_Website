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
        $client->followRedirect();

        $crawler = $client->request($httpMethod, '/food/detail/122');
        $linkText = 'Upvote';

        $link = $crawler->selectLink($linkText)->link();
        $client->click($link);

        $content = $client->getResponse()->getContent();

        $redirect_code = 302;
        $this->assertSame($redirect_code, $client->getResponse()->getStatusCode());
        $this->assertContains('/setscore', strtolower($content));
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
        $client->followRedirect();

        $crawler = $client->request($httpMethod, '/food/detail/122');
        $linkText = 'Upvote';

        $link = $crawler->selectLink($linkText)->link();
        $client->click($link);

        $content = $client->getResponse()->getContent();

        $redirect_code = 302;
        $this->assertSame($redirect_code, $client->getResponse()->getStatusCode());
        $this->assertContains('/food/detail/122', strtolower($content));
    }
}