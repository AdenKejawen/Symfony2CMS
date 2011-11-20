<?php

namespace CMS\System\Bundle\SonataExtaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('CMSSonataExtraBundle:Default:index.html.twig', array('name' => $name));
    }
}
