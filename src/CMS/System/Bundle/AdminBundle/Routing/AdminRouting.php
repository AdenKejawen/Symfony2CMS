<?php

namespace CMS\System\Bundle\AdminBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use CMS\System\Bundle\AdminBundle\Admin\AdminPool;

class AdminRouting extends Loader
{
    private $adminPool;

    public function __construct(AdminPool $adminPool)
    {     
        $this->adminPool = $adminPool;
    }

    public function supports($resource, $type = null)
    {   
        return $type === 'cms_admin';
    }

    public function load($resource, $type = null)
    {
        
        $defaults     = array('_controller' => 'CMSAdminBundle:Main:execute');
        $requirements = array();
        $collection   = new RouteCollection();
        
        $admins = $this->adminPool->getAdmins();
        
        foreach($admins as $serviceId => $admin){
            
            $pattern = $admin->getUniqueName();
            
            $defaults['unique'] = $pattern;
            
            $routeName = str_replace('-', '_', $pattern);
            
            $routeName = 'cms_admin_'.$routeName;
            
            $actions = $admin->getActions();

            foreach($actions as $name => $action){
                
                $defaults['action'] = $name;
                
                $route = new Route($pattern.$action->getPattern(), $defaults, $requirements);
                
                $collection->add($routeName.'_'.$name, $route);
                
            }
            
            
        }
        
        

        return $collection;
    }
}
