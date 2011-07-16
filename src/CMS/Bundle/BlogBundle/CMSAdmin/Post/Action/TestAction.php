<?php

namespace CMS\Bundle\BlogBundle\CMSAdmin\Post\Action;

use CMS\System\Bundle\AdminBundle\Admin\AdminAction;

class TestAction extends AdminAction
{   
    public function execute(){
        
        $name = $this->admin->getName();
        
        return $this->render('CMSBlogBundle:Action:test.html.twig', array('name' => $name));
    }   
}