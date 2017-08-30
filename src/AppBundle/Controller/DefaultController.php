<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Form\Type\CommandeType;
use AppBundle\Service\Calculator;
use AppBundle\Service\CodeGenerator;
use AppBundle\Service\DateValidator;
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
            $commande->setRandom($this->get(CodeGenerator::class)->random());

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

    public function checkoutAction(Commande $commande, Request $request)
    {
        Stripe::setApiKey('sk_test_fuWg21NaTTnINaBbLI0xG0vg');

        // Get the credit card details submitted by the form
        // use $request->get('stripeToken') à la place de $_POST['stripeToken']
        $token = $request->get('stripeToken');

        // Create a charge: this will charge the user's card
        try {
            \Stripe\Charge::create(array(
                "amount" => $commande->getPrixTotal()*100, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - OpenClassrooms Exemple"
            ));
            $this->addFlash("success","Paiement accepté");
            $commande->setPayed(true);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("order_confirmation", array(
                'id' => $commande->getId())
            );
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Erreur lors du paiement");
            return $this->redirectToRoute("order_checkout", array(
                'id' => $commande->getId()
            ));
            // The card has been declined
        }
    }

    /**
     * @Route("/confirmation/{id}", name="order_confirmation")
     * @param $id
     */

    public function sendConfirmationMailAction(Commande $commande)
    {
        if(!$commande->isPayed()) {
            return $this->redirectToRoute("commande_show", array(
                'id' => $commande->getId()
            ));
        }
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
        $this->get('mailer')->send($message);

        return $this->render('confirmation.html.twig', array(
            'commande' => $commande
        ));
    }
}
