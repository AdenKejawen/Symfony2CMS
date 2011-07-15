<?php

namespace CMS\Bundle\BlogBundle\CMSAdmin;

use CMS\System\Bundle\AdminBundle\Admin\Admin;
use CMS\Bundle\BlogBundle\Form\PostType;

class Post extends Admin
{           
    public function configure(){
       
       $this->setName('Post');
       
       $this->setGroup('Blog');
       
       $this->setEntity('CMSBlogBundle:Post');
        
       $this->setForm(new PostType);
       
       $this->setList(array(
                  'title',
                  'body'
               ));
    }   
}