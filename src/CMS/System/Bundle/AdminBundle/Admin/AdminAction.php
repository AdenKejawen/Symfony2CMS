<?php

namespace CMS\System\Bundle\AdminBundle\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminAction extends Controller
{
    protected $admin;
    
    protected $pattern = '';
    
    protected $config;
    
    public function defaultConfigure($admin){
        
        $this->setAdmin($admin);   
        
        $this->configure(); 
        
        return $this;
    }
    
    public function configure(){}
    
    public function setAdmin($admin){
        
        $this->admin = $admin;
        
    }
    
    
    public function getAdmin(){
        
       return $this->admin;
        
    }
    
    public function setPattern($pattern){
        
        $this->pattern = $pattern;
        
    }
    
    public function getPattern(){
        
        return $this->pattern;
    }
    
    public function setConfig($config = array()){
        
        $this->config = $config;
    }
    
    public function getConfig(){
        
       return $this->config;
    }
    
    public function execute(){
        
    }    
}