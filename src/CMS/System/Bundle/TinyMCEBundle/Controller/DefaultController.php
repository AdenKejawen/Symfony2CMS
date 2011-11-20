<?php

namespace CMS\System\Bundle\TinyMCEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('CMSTinyMCEBundle:Default:index.html.twig', array('name' => $name));
    }
}
