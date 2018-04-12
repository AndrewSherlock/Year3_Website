<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 06/04/2018
 * Time: 15:31
 */

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class ReviewControllerTest extends WebTestCase
{
    public function testNewReview()
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

        $url = '/review/new/155';
        $crawler = $client->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $buttonName = 'Submit Review';
        $form = $crawler->selectButton($buttonName)->form();

        $form['form[summary]'] = 'Test review';
        $form['form[placeOfPurchase]'] = 'Test place';
        $form['form[price]'] = '3';
        $form['form[stars]'] = '3';

        $this->assertNotNull($form);

        $client->submit($form);
        $content = $client->getResponse()->getContent();

        $this->assertContains('user added', strtolower($content));
    }

    public function testStarsOutOfBounds()
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

        $url = '/review/new/155';
        $crawler = $client->request($httpMethod, $url);

        $buttonName = 'Submit Review';
        $form = $crawler->selectButton($buttonName)->form();

        $form['form[summary]'] = 'Test review';
        $form['form[placeOfPurchase]'] = 'Test place';
        $form['form[price]'] = '3';
        $form['form[stars]'] = '6';

        $client->submit($form);
        $content = $client->getResponse()->getContent();

        $this->assertContains('enter a value between 0 and 5', strtolower($content));
    }

    public function testSetScore()
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

        $url = '/food/detail/155';
        $crawler = $client->request($httpMethod, $url);

        $linkText = 'Downvote';
        $link = $crawler->selectLink($linkText)->link();
        $client->click($link);

        $content = $client->getResponse()->getContent();
        $this->assertContains('review voted', strtolower($content));
    }

    public function testEditReview()
    {
        $httpMethod = 'GET';
        $client = static::createClient();
        $url = '/login';
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);
        $client->followRedirects(true);

        $url = '/review/583/edit';
        $crawler = $client->request($httpMethod, $url);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $buttonName = 'Edit';
        $form = $crawler->selectButton($buttonName)->form();

        $client->submit($form);

        $content = $client->getResponse()->getContent();
        $this->assertContains('review edited successfully', strtolower($content));

    }

    public function testEditDelete()
    {
        $httpMethod = 'GET';
        $client = static::createClient();
        $url = '/login';
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);
        $client->followRedirects(true);

        $url = '/review/620/delete';
        $crawler = $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('review deleted successfully', strtolower($content));
    }

    public function testShowUserReviews()
    {
        $httpMethod = 'GET';
        $client = static::createClient();
        $url = '/login';
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'form[login]';
        $button = $crawler->selectButton($buttonName);
        $form = $button->form();
        $form['form[username]'] = 'admin';
        $form['form[password]'] = 'admin';
        $client->submit($form);
        $client->followRedirects(true);


        $url = '/review/show_users/206';
        $crawler = $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();
        $this->assertContains('review list', strtolower($content));

    }
}