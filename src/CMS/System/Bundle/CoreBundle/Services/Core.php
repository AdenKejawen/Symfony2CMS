<?php

namespace CMS\System\Bundle\CoreBundle\Services;

class Core {
    
    public function __construct(){
        
    }
    
    static public function init(){
        return new Core;
    }
    
    public function getUploadsDir(){
        return $this->getRootDir().'/uploads';
    }
    
    public function getRootDir(){
        return $_SERVER['DOCUMENT_ROOT'];
    }
    
}