<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 28/08/2017
 * Time: 19:34
 */

namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Billet;
use AppBundle\Entity\Commande;
use PHPUnit\Framework\TestCase;

class CommandeTest extends TestCase
{
    /**
     * @test
     */
    public function getPrixTotalTest()
    {
        $commande = new Commande();

        $billet1 = new Billet();
        $billet2 = new Billet();

        $billet1->setPrixBillet(9);
        $billet2->setPrixBillet(15);

        $commande->addBillet($billet1);
        $commande->addBillet($billet2);

        $this->assertEquals(25, $commande->getPrixTotal());
    }
}