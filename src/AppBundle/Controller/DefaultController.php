<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Billet;
use AppBundle\Entity\Commande;
use AppBundle\Form\CommandeType;
use AppBundle\Service\Calculator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Stripe\Stripe;
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
            $commande->setRandom($this->get(Calculator::class)->random());

            if ($this->get(Calculator::class)->datePassed($commande->getDatereza())) {
                $this->addFlash(
                    'notice',
                    'La date sélectionnée est passée'
                );
                return $this->redirectToRoute('add_commande');
            }

            if ($this->get(Calculator::class)->isNotWorkable($commande->getDatereza())) {
                $this->addFlash(
                    'notice',
                    'La date sélectionnée est un jour férié'
                );
                return $this->redirectToRoute('add_commande');
            }

            if ($this->get(Calculator::class)->overSellForADay( $repositoryCommande, $repositoryBillet, $commande)) {
                $this->addFlash(
                    'notice',
                    'Le nombre de billets vendus pour la date sélectionnée est dépassé !'
                );
                return $this->redirectToRoute('add_commande');
            }

            if ($this->get(Calculator::class)->halfDayWarning($commande->getDatereza(), $commande->getBillets())) {
                $this->addFlash(
                    'notice',
                    'Un billet de type "journée" ne peut être acheté après 14H, désolé'
                );
                return $this->redirectToRoute('add_commande');
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
    public function showCommandeAction(Commande $commande)
    {
        return $this->render('payment.html.twig', array(
            'commande' => $commande,
        ));
    }

    /**
     * @Route("/checkout/{id}", name="order_checkout", methods="POST")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function checkoutAction(Commande $commande)
    {
        Stripe::setApiKey('sk_test_fuWg21NaTTnINaBbLI0xG0vg');

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $commande->getPrixTotal()*100, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - OpenClassrooms Exemple"
            ));
            $this->addFlash("success","Paiement accepté");
            return $this->redirectToRoute("order_confirmation", array(
                'id' => $commande->getId())
            );
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Erreur lors du paiement");
            return $this->redirectToRoute("order_checkout");
            // The card has been declined
        }
    }

    /**
     * @Route("/confirmation/{id}", name="order_confirmation")
     * @param $id
     */

    public function sendConfirmationMailAction(Commande $commande)
    {
        $mailer = $this->get('mailer');
        $message = (new \Swift_Message('Confirmation de commande'))
            ->setFrom('christophe.barnet@gmail.com')
            ->setTo($commande->getMail())
            ->setBody(
                $this->renderView(
                    ':Emails:confirmation_mail.html.twig',
                    array(
                        'commande' => $commande
                    )
                ),
                'text/html'
            );
        $mailer->send($message);

        return $this->render('confirmation.html.twig', array(
            'commande' => $commande,
            'billets' => $commande->getBillets()
        ));
    }
}
