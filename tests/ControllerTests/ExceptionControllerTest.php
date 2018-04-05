<?php

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class ExceptionControllerTest extends WebTestCase{

    public function testExceptionThrow()
    {
        $url = '/exception';
        $httpMethod = 'GET';
        $client = static::createClient();

        $client->request($httpMethod, $url);

        $content = $client->getResponse()->getContent();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('page not found', strtolower($content));
    }

}