<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 10/08/2017
 * Time: 10:45
 */

namespace AppBundle\Service;


use AppBundle\Entity\Commande;


class Calculator
{
    // camelCase pour var

    /**
     * @var array
     */
    private $listeTarifs;

    public function __construct(array $listeTarifs)
    {
        $this->listeTarifs = $listeTarifs;

    }

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

    public function datePassed(\DateTime $dateReza)
    {
        $dateNow = new \DateTime('now');
        return $dateReza < $dateNow;
    }

    function isNotWorkable(\DateTime $date)
    {
        $year = date('Y',$date->getTimestamp());

        $easterDate  = easter_date($year);
        $easterDay   = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear   = date('Y', $easterDate);

        $holidays = array(
            // Dates fixes
            mktime(0, 0, 0, 1,  1,  $year),  // 1er janvier
            mktime(0, 0, 0, 5,  1,  $year),  // Fête du travail
            mktime(0, 0, 0, 5,  8,  $year),  // Victoire des alliés
            mktime(0, 0, 0, 7,  14, $year),  // Fête nationale
            mktime(0, 0, 0, 8,  15, $year),  // Assomption
            mktime(0, 0, 0, 11, 1,  $year),  // Toussaint
            mktime(0, 0, 0, 11, 11, $year),  // Armistice
            mktime(0, 0, 0, 12, 25, $year),  // Noel

            // Dates variables
            mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear),
            mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
            mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear),
        );

        return in_array($date->getTimestamp(), $holidays);
    }

    public function overSellForADay($repositoryCommande, $repositoryBillet, $commande)
    {
        $listeId = [];

        $commandesJour = $repositoryCommande->findBy(array(
                'datereza' => $commande->getDatereza())
        );

        foreach ($commandesJour as $commandeJour) {
            $listeId[] = $commandeJour->getId();
        }

        if ($listeId != null) {
            $billetsJour = $repositoryBillet->findBy(array(
                'commande' => $listeId
            ));
            dump($billetsJour);

            echo count($billetsJour);

            if (count($billetsJour) > 1000) {
                return true;
            }
        }
    }

    public function priceCalculator(Commande $commande)
    {
        foreach ($commande->getBillets() as $billet)
        {
            // $tarif demi prend pour valeur 1 pour BilletJournée et 2 pour BilletDemiJournée
            $tarifDemi = $billet->getTypeBillet();

            if ($billet->getTarifReduit() == true) {
                $billet->setPrixBillet($this->listeTarifs['tarif_reduit'] / $tarifDemi);
            } else {
                $age = $this->ageCalculatorFromToday($billet->getDateNaissance());
                $billet->setPrixBillet($this->listeTarifs[$this->ageCategory($age)] / $tarifDemi);
            }
        }
    }

    public function random()
    {
        $string = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);

        return $string;


    }
}