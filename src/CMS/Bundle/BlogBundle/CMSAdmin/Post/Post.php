<?php

namespace CMS\Bundle\BlogBundle\CMSAdmin\Post;

use CMS\System\Bundle\AdminBundle\Admin\Admin;
use CMS\Bundle\BlogBundle\Form\PostType;

class Post extends Admin
{           
    public function configure(){
       
       $this->setName('Post');
       
       $this->setGroup('Blog');
       
       $this->setEntityClass('CMS\Bundle\BlogBundle\Entity\Post');
        
       //$this->setForm(new PostType);
       
       $this->getAction('list')->setListFields(array('id', 'title', 'body'));
       
       
    }   
}