<?php

namespace CMS\System\Bundle\AdminBundle\Admin\Action;

use CMS\System\Bundle\AdminBundle\Admin\AdminAction;

class EditAction extends AdminAction
{   
    public function execute(){
        
        $name = $this->admin->getName();
        
        $id = $this->getRequest()->get('id');
        
        return $this->render('CMSAdminBundle:Action:edit.html.twig', array('name' => $name, 'id' => $id));
    }   
}