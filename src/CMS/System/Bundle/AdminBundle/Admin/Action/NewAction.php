<?php

namespace CMS\System\Bundle\AdminBundle\Admin\Action;

use CMS\System\Bundle\AdminBundle\Admin\AdminAction;

class NewAction extends AdminAction
{   
    public function execute(){
        
        $name = $this->getAdmin()->getName();
        
        return $this->render('CMSAdminBundle:Action:new.html.twig', array('name' => $name));
    }   
}