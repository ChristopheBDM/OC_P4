<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Billet;
use AppBundle\Entity\Commande;
use AppBundle\Form\BilletType;
use AppBundle\Form\CommandeType;
use AppBundle\Service\Calculator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="add_commande")
     */
    public function addCommandeAction(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);

            // utilisation de Calculator en passant une commande
            //$calculator = new Calculator();
            //$calculator->priceCalculator($commande);

            $a_billets = $commande->getBillets();

            foreach ($a_billets as $billet) {
                // utilisation de Calculator en passant un billet
                $calculator = new Calculator();
                //$calculator->priceCalculator($billet);

                // utlisation de la méthode de calcul implémentée dans le controller
                //$prix_billet = $this->priceCalculator($billet);

                $billet->setCommande($commande);
                //$billet->setPrixBillet($prix_billet);
                $billet->setPrixBillet($calculator->getPrice());

                $em->persist($billet);

                // var de test $stock = $billet;
            }

            $em->flush();

            /*
             * return pour test
             *
            return $this->render('test.html.twig', array(
                'tarifs' => $a_billets,
                'billet' => $stock,
                //'mail' => $mail
            ));
            */

            return $this->redirect($this->generateUrl(
                'commande_show',
                array('id' => $commande->getId())
            ));
        }

        return $this->render('index.html.twig', array(
            'form' => $form->createView(),
        ));

        /*return $this->redirect($this->generateUrl(
            'commande_show',
            array('id' => $commande->getId())
        ));*/
    }

    /**
     * @Route("/show/{id}", name="commande_show")
     * @param $id
     * @return Response
     */
    public function showCommandeAction($id)
    {
        $commande = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($id);

        $a_billets = $this->getDoctrine()
            ->getRepository(Billet::class)
            ->findBy(array('commande' => $commande->getId()));

        if (!$commande) {
            throw $this->createNotFoundException(
                'Pas de commande avec l\'id ' . $id
            );
        }

        return $this->render('confirm_view.html.twig', array(
            'commande' => $commande,
            'billets' => $a_billets
        ));
    }

    /*
     * méthode de calcul implémentée dans le controleur
     *
    public function priceCalculator($billet)
    {
        $liste_tarifs = $this->getParameter('liste_tarifs');

        if ($billet['tarifReduit'] !== false) {
            return $liste_tarifs['tarif_reduit'];
        } else {
            $age = $this->ageCalculatorFromToday($billet['dateNaissance']);
            return $liste_tarifs[$this->ageCategory($age)];
        }
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
    */
}
