<?php

namespace CMS\Bundle\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('image', 'image')
            ->add('image_delete', 'checkbox', array('required' => false))
            ->add('file', 'file')
            ->add('file_delete', 'checkbox', array('required' => false))
            ->add('category')
            ->add('slug')
        ;
        
    }
    
    public function getName(){
        return 'post'; 
    }
}