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

    public function priceCalculator(Commande $commande)
    {
        foreach ($commande->getBillets() as $billet)
        {
            if ($billet->getTarifReduit() == true) {
                $billet->setPrixBillet($this->listeTarifs['tarif_reduit']);
            } else {
                $age = $this->ageCalculatorFromToday($billet->getDateNaissance());
                $billet->setPrixBillet($this->listeTarifs[$this->ageCategory($age)]);
            }
        }
    }
}