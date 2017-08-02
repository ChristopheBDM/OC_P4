<?php

namespace BDM\BilletterieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BDMBilletterieBundle:Default:index.html.twig');
    }
}
