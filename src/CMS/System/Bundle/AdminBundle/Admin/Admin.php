<?php

namespace CMS\System\Bundle\AdminBundle\Admin;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Admin extends ContainerAware
{
    protected $config;
    
    protected $list;
    
    protected $form;
    
    protected $filter;
    
    protected $entity;
    
    protected $uniqueName;
    
    protected $action;
    
    protected $actions = array();
    
    protected $routes = array();
    
    public function defaultConfigure(){
        
        $this->setName('Object');
        
        $this->setGroup('Main');
           
    }
    
    public function configure(){}
    
    public function getConfig(){
        
        return $this->config;
    }
    
    public function setUniqueName($name){
        
        $this->uniqueName = $name;
    }
    
    public function getUniqueName(){
        
       return $this->uniqueName;
    }
    
    public function setName($name){
        
        $this->config['name'] = $name;
        
    }
    
    public function getName(){
        
        return $this->config['name'];
    }
    
    public function setEntityClass($entity){
        
        $this->entity = $entity;
        
    }
    
    public function getEntityClass(){
        
        return $this->entity;
    }
    
    public function setForm($form){
        
        $this->form = $form;
    }
    
    public function setGroup($group){
        
       $this->config['group'] = $group; 
       
    }
    
    public function getGroup(){
        
      return $this->config['group'];
      
    }
    
    public function registerRoutesForActions(){
        
        $routeName = str_replace('-', '_', $this->getUniqueName());
            
        $routeName = 'cms_admin_'.$routeName;
        
        foreach($this->getActions() as $name => $action){
          
          $this->addRoute($name, $routeName.'_'.$name);
        }
        
    }
    
    public function addRoute($actionName, $routeName){
        
        $this->routes[$actionName] = $routeName;
        
    }
    
    public function getRoute($actionName){
        
        if(!isset($this->routes[$actionName])){
            
           throw new \LogicException(sprintf('Route for action %s not found', $actionName));
       }
        
       return $this->routes[$actionName];
    }
    
    public function getRoutes(){
        
        return $this->routes;
    }
    
    
    public function addAction($name, $service){
        
        $this->actions[$name] = $service;
        
    }
    
    public function hasAction($name){
        
        if(isset($this->actions[$name])){
            
            return true;
            
        }
        
        return false;
    }
    
    
    public function getAction($name){
       
       if(!isset($this->actions[$name])){
            
           throw new \LogicException(sprintf('Action %s not found', $name));
       }
        
       return $this->actions[$name];
       
    }
    
    public function getActions(){
        
       return $this->actions;
       
    }
    
    public function executeAction($name){
        
        if(!isset($this->actions[$name])){
            
           throw new \LogicException(sprintf('Action %s not found', $name));
       }
        
       return $this->actions[$name]->defaultConfigure($this)->execute();
       
    }
}