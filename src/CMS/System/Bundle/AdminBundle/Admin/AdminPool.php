<?php

/*
 * This file is part of the WhiteOctoberAdminBundle package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CMS\System\Bundle\AdminBundle\Admin;

use Symfony\Component\DependencyInjection\ContainerAware;

class AdminPool extends ContainerAware
{
    private $adminIds;

    public function __construct(array $adminIds)
    {
        $this->adminIds = $adminIds;
    }

    public function getAdminIds()
    {
        return $this->adminIds;
    }

    public function getAdmins()
    {
        $admins = array();
        
        foreach ($this->adminIds as $adminId) {
            
            $admins[$adminId] = $this->container->get($adminId);
            
        }

        return $admins;
    }
    
    public function getAdminByUniqueName($name)
    {
        if(isset($this->adminIds[$name])){
            
            $serviceId = $this->adminIds[$name];
            
            return $this->container->get($serviceId);
        }

    }
    
    public function hasUniqueName($name){
        
        if(isset($this->adminIds[$name])){
            
            return true;
        }
        
        return false;
           
    }
    
    public function getGroupAdmins()
    {
        $admins = array();
        
        foreach ($this->adminIds as $adminId) {
            
            $service = $this->container->get($adminId);
            
            $admins[$service->getGroup()][$adminId] = $service;
            
            unset($service);
        }

        return $admins;
    }
    
    public function addAdmin($admin){
        
        $this->adminIds[] = $admin;
    }
    
}