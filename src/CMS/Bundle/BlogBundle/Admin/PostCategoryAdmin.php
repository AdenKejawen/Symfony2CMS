<?php

namespace CMS\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class PostCategoryAdmin extends Admin
{
    protected $list = array(
        'title' => array('identifier' => true),
    );

    protected $form = array(
        'title',
    );

    protected $filter = array(
        'title',
    );
}