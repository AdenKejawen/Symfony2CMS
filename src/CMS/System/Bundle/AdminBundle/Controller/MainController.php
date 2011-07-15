<?php

namespace CMS\System\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MainController extends Controller
{
    
    public function dashboardAction()
    {
        $groups_admins = $this->get('cms_admin.admin_pool')->getGroupAdmins();
        
        return $this->render('CMSAdminBundle:Main:dashboard.html.twig', array('groups_admins' => $groups_admins));
    }
    
    public function testAction()
    {
        $admins = $this->get('cms_admin.admin_pool')->getAdmins();
        
        return $this->render('CMSAdminBundle:Main:dashboard.html.twig', array('admins' => $admins));
    }
    
}
