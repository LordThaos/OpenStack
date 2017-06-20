<?php

namespace OpenStack\commandeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OpenStackcommandeBundle:Default:index.html.twig');
    }
}
