<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testShowAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/show/15');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Date de visite")')->count()
        );
    }
}
