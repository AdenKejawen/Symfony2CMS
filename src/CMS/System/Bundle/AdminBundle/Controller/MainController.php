<?php

namespace CMS\System\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MainController extends Controller
{
    
    public function dashboardAction()
    {
        $groups_admins = $this->get('cms_admin.admin_pool')->getGroupAdmins();
        
        return $this->render('CMSAdminBundle:Main:dashboard.html.twig', array('groups_admins' => $groups_admins));
    }
    
    public function testAction()
    {
        
        $groups_admins = $this->get('cms_admin.admin_pool')->getGroupAdmins();
        
        return $this->render('CMSAdminBundle:Main:dashboard.html.twig', array('groups_admins' => $groups_admins));
    }
    
    
    public function executeAction($unique, $action)
    {
        
        $admin = $this->get('cms_admin.admin_pool')->getAdminByUniqueName($unique);
        
        return $admin->executeAction($action);
        
    }
    
}
