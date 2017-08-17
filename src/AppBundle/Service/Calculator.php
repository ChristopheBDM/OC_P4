<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 10/08/2017
 * Time: 10:45
 */

namespace AppBundle\Service;


use AppBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class Calculator extends Controller
{
    public function ageCalculatorFromToday(\DateTime $dateInitiale)
    {
        return $dateInitiale->diff(new \DateTime())->format('%Y');
    }


    public function ageCategory($age)
    {
        if ($age < 4) {
            return 'tarif_under4';
        } elseif ($age >= 4 && $age < 12) {
            return 'tarif_enfant';
        } elseif ($age >= 12 && $age < 60) {
            return 'tarif_normal';
        } elseif ($age >= 60) {
            return 'tarif_senior';
        }
    }

    // calculateur de prix en fonction d'un billet
    public function priceCalculator($billet)
    {
        $liste_tarifs = $this->getParameter('liste_tarifs');

        if ($billet['tarifReduit'] == true) {
            return $liste_tarifs['tarif_reduit'];
        } else {
            $age = $this->ageCalculatorFromToday($billet['dateNaissance']);
            return $liste_tarifs[$this->ageCategory($age)];
        }
    }

    /*
    // calculateur de prix en fonction d'une commande
    public function priceCalculator(Commande $commande)
    {
        $liste_tarifs = $this->getParameter('liste_tarifs');
        $a_billets = $commande->getBillets();

        foreach ($a_billets as $billet)
        {
            if ($billet['tarifReduit'] == true) {
                return $liste_tarifs['tarif_reduit'];
            } else {
                $age = $this->ageCalculatorFromToday($billet['dateNaissance']);
                return $liste_tarifs[$this->ageCategory($age)];
            }
        }
    }
    */

    public function getPrice()
    {
        $price = 10;
        return $price;
    }
}