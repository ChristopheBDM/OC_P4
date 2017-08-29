<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 29/08/2017
 * Time: 18:39
 */

namespace Tests\AppBundle;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/'),
            array('/show/{id}'),
            array('/checkout/{id}'),
            array('/confirmation/{id}')
        );
    }
}