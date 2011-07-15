<?php

namespace CMS\Bundle\BlogBundle\CMSAdmin;

use CMS\System\Bundle\AdminBundle\Admin\Admin;
use CMS\Bundle\BlogBundle\Form\PostCategoryType;

class PostCategory extends Admin
{
   public function configure(){
       
       $this->setName('Post Category');
       
       $this->setGroup('Blog');
       
       $this->setEntity('CMSBlogBundle:PostCategory');
        
       $this->setForm(new PostCategoryType);
       
       $this->setList(array(
                  'title'
               ));
    }   
}