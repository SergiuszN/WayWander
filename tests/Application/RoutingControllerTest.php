<?php

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class RoutingControllerTest extends WebTestCase
{
    public function testNavigate(): void
    {
        $client = static::createClient();
        $client->request('GET', '/routing/CZE/ITA');
        $this->assertResponseIsSuccessful();
        $this->assertEquals('{"route":["CZE","AUT","ITA"]}', $client->getResponse()->getContent());

        $client->catchExceptions(false);
        try {
            $client->request('GET', '/routing/ABW/SVN');
        } catch (Throwable $throwable) {
            $this->assertInstanceOf(BadRequestHttpException::class, $throwable);
        }
    }
}
