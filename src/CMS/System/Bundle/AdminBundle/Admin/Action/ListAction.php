<?php

namespace CMS\System\Bundle\AdminBundle\Admin\Action;

use CMS\System\Bundle\AdminBundle\Admin\AdminAction;

class ListAction extends AdminAction
{   
    public function execute(){
        
        $name = $this->admin->getName();
        
        return $this->render('CMSAdminBundle:Action:list.html.twig', array('name' => $name));
    }   
}