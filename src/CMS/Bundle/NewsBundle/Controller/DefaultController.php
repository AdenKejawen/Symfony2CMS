<?php

namespace CMS\Bundle\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('CMSNewsBundle:Default:index.html.twig', array('name' => $name));
    }
}
