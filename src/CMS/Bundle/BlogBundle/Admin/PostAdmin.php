<?php

namespace CMS\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class PostAdmin extends Admin
{
    protected $list = array(
        'title' => array('identifier' => true),
        'body',
        'category'
    );

    protected $form = array(
        'title',
        'body',
        'image',
        'category' => array('edit' => 'list')
    );

    protected $filter = array(
        'title',
        'category' => array('form_field_options' => array('expanded' => true))
    );
}