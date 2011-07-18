<?php

namespace CMS\Bundle\BlogBundle\CMSAdmin\PostCategory;

use CMS\System\Bundle\AdminBundle\Admin\Admin;
use CMS\Bundle\BlogBundle\Form\PostCategoryType;

class PostCategory extends Admin
{
   public function configure(){
       
       $this->setName('Post Category');
       
       $this->setGroup('Blog');
       
       $this->setEntityClass('CMS\Bundle\BlogBundle\Entity\PostCategory');
        
       $this->setForm(new PostCategoryType);
       
    }   
}