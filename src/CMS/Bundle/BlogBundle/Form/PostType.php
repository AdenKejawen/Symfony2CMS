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
            //->add('created')
            //->add('updated')
            ->add('body')
            ->add('image')
            //->add('category')
        ;
    }
}