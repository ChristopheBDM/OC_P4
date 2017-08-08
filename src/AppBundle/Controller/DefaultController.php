<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Billet;
use AppBundle\Form\BilletType;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $billet = new Billet();
        $form_billet = $this->createForm(BilletType::class, $billet);
        $form_user = $this->createForm(UserType::class, $billet);

        return $this->render('index.html.twig', array(
            'form_billet' => $form_billet->createView(),
            'form_user' => $form_user->createView(),
        ));
    }
}
