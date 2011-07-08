<?php

namespace CMS\Bundle\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use CMS\System\Component\Form\Extension\Core\Type\FileType;
use CMS\System\Component\Form\Extension\Core\Type\ImageType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('image', new ImageType())
            ->add('image_delete', 'checkbox', array('required' => false))
            ->add('file', new FileType())
            ->add('file_delete', 'checkbox', array('required' => false))
            ->add('slug')
        ;
        
    }
    
    public function getName(){
        
        return 'Post';
        
    }
}