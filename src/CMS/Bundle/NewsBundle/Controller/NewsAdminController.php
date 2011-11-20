<?php

/**
 * Created by JetBrains PhpStorm.
 * User: GrifiS
 * Date: 07.11.11
 * Time: 22:57
 * To change this template use File | Settings | File Templates.
 */

namespace CMS\Bundle\NewsBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class NewsAdminController extends Controller
{

  public function configure(){
    
    parent::configure();

    $this->admin->setUniqid('news');

    $templates = $this->admin->getTemplates();

    $templates['edit'] = 'CMSNewsBundle:Admin:edit.html.twig';

    $this->admin->setTemplates($templates);
    
  }

}