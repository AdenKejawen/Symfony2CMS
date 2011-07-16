<?php

namespace CMS\System\Bundle\AdminBundle\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminAction extends Controller
{
    protected $admin;
    
    protected $pattern = '';
    
    public function configure($admin){
        
        $this->admin = $admin;    
        
        return $this;
    }
    
    public function setPattern($pattern){
        
        $this->pattern = $pattern;
        
    }
    
    public function getPattern(){
        
        return $this->pattern;
    }
    
    public function execute(){
        
    }    
}