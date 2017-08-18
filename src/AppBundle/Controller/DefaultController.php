<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Billet;
use AppBundle\Entity\Commande;
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
            $repositoryCommande = $this->getDoctrine()->getRepository(Commande::class);
            $repositoryBillet = $this->getDoctrine()->getRepository(Billet::class);

            $commandesJour = $repositoryCommande->findBy(array(
                'datereza' => $commande->getDatereza())
            );
            foreach ($commandesJour as $commandeJour) {
                $listeId[] = $commandeJour->getId();
            }
            $billetsJour = $repositoryBillet->findBy(array(
                'commande' => $listeId
            ));
            dump($billetsJour);

            echo count($billetsJour);

            if (count($billetsJour) > 1000) {
                throw $this->createNotFoundException(
                    'Le nombre de billets vendus pour la date sélectionnée est dépassée'
                );
            }

            if ($this->get(Calculator::class)->datePassed($commande->getDatereza())) {
                throw $this->createNotFoundException(
                    'La date sélectionnée est passée'
                );
            }
            $this->get(Calculator::class)->priceCalculator($commande);

            $em->persist($commande);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'commande_show',
                array('id' => $commande->getId())
            ));
        }

        return $this->render('index.html.twig', array(
            'form' => $form->createView(),
        ));
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

        $billets = $this->getDoctrine()
            ->getRepository(Billet::class)
            ->findBy(array('commande' => $commande->getId()));

        if (!$commande) {
            throw $this->createNotFoundException(
                'Pas de commande avec l\'id ' . $id
            );
        }

        return $this->render('confirm_view.html.twig', array(
            'commande' => $commande,
            'billets' => $billets
        ));
    }
}
