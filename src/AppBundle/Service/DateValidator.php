<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 28/08/2017
 * Time: 20:12
 */

namespace AppBundle\Service;


use AppBundle\Repository\BilletRepository;
use AppBundle\Repository\CommandeRepository;

class DateValidator
{
    private $billetRepository;
    private $commandeRepository;

    public function __construct(BilletRepository $billetRepository, CommandeRepository $commandeRepository) //mettre dependance d'un service dans le constructeur pour code propre
    {
        $this->billetRepository = $billetRepository;
        $this->commandeRepository = $commandeRepository;
    }

    public function halfDayWarning(\DateTime $dateReza, $billets)
    {
        $dateNow = new \DateTime('now');
        $dateReza = $dateReza->format('Y-m-d');
        $dateNow = $dateNow->format('Y-m-d');
        $listeTypeBillets = [];

        foreach ($billets as $billet) {
            $listeTypeBillets[] = $billet->getTypeBillet();
        }

        if ($dateReza == $dateNow && in_array(1, $listeTypeBillets)) {
            $myTime = date('Y-m-d H:i', mktime(14, 0, 0));
            $myTime = strtotime($myTime);

            if(time() > $myTime){
                return true;
            }
        } else {return false;}
    }

    public function overSellForADay($commande)
    {
        $listeId = [];

        $commandesJour = $this->commandeRepository->findBy(array(
                'datereza' => $commande->getDatereza())
        );

        foreach ($commandesJour as $commandeJour) {
            $listeId[] = $commandeJour->getId();
        }

        if ($listeId !== null) {
            $billetsJour = $this->billetRepository->findBy(array(
                'commande' => $listeId
            ));
            if (count($billetsJour) > 1000) {
                return true;
            }
        }
    }

    public function isNotWorkable(\DateTime $date)
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

    public function sundayIsClose(\DateTime $dateReza)
    {
        if (date('l', $dateReza->getTimestamp()) == 'Sunday')
        {
            return true;
        }
    }

    public function datePassed(\DateTime $dateReza)
    {
        $dateNow = new \DateTime('yesterday 23:59');
        return $dateReza < $dateNow;
    }
}