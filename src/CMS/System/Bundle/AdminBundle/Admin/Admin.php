<?php

namespace CMS\System\Bundle\AdminBundle\Admin;

use Symfony\Component\DependencyInjection\ContainerAware;

class Admin extends ContainerAware
{
    protected $config;
    
    protected $list;
    
    protected $form;
    
    protected $filter;
    
    protected $entity;
    
    protected $uniqueName;
    
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
    
    public function setEntity($entity){
        
        $this->entity = $entity;
        
    }
    
    public function getEntity(){
        
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
    
    public function setFilter($filter){
        
        $this->filter = $filter;
    }
    
    public function getFilter(){
        
       return $this->filter;
    }
    
    public function setList(Array $list){
        
        $this->list = $list;
    }
    
    public function getList(){
        
        return $this->list;
    }
}