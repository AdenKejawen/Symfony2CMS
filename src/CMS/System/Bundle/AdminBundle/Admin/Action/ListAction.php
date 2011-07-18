<?php

namespace CMS\System\Bundle\AdminBundle\Admin\Action;

use CMS\System\Bundle\AdminBundle\Admin\AdminAction;
use Zend\Paginator\Paginator;

class ListAction extends AdminAction
{
    protected $listFields = array();
    
    protected $itemListActions = array();
    
    protected $listActions = array();
    
    public function configure(){
        
        //var_dump($this->getAdmin()->getRoutes()); die;
        
        $this->setItemListActions(array('edit'));
        
        $this->setListActions(array('new'));
    }
    
    public function execute(){
        
        
        
        $name = $this->getAdmin()->getName();
        
        $fields = $this->getFields();
        
        $itemListActions = $this->getItemListActions();
        
        $listActions = $this->getListActions();
        
        $repository = $this->getDoctrine()->getRepository($this->admin->getEntityClass());
        
        
        $query = $repository->createQueryBuilder('a')
                            ->select($this->getFieldsForSelect())
                            ->orderBy('a.id', 'DESC')
                            ->getQuery();
                            
        $adapter = $this->get('knp_paginator.adapter');
        $adapter->setQuery($query);
        $adapter->setDistinct(true);

        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($this->get('request')->query->get('page', 1));
        $paginator->setItemCountPerPage(15);
        $paginator->setPageRange(5);
        
        return $this->render('CMSAdminBundle:Action:list.html.twig', array(
                        'name' => $name, 
                        'fields' => $fields, 
                        'item_list_actions' => $itemListActions,
                        'list_actions' => $listActions,
                        'paginator' => $paginator
                        ));
    }
    
    public function getMetaData(){
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $metadataFactory = $em->getMetadataFactory();
        
        $md = $metadataFactory->getMetadataFor($this->admin->getEntityClass());

        return $md;
    }
    
    public function setListFields($fields){
        
        $this->listFields = $fields;
    }
    
    public function getListFields(){
        
       return $this->listFields;
    }
    
    public function getFields(){
        
        $fields = $this->getListFields();
        
        if(!empty($fields)) return $fields;
        
        $md = $this->getMetaData();
        
        $fields = array();
        
        foreach ($md->fieldMappings as $field) {
            $fields[] = $field['fieldName'];
        }
        
        return $fields;
        
    }
    
    public function getFieldsForSelect($alias = 'a'){
        
        $_fields = $this->getListFields();
        
        if(!empty($_fields)){
            
            foreach ($_fields as $field) {
                
                $fields[] = $alias.'.'.$field;
                
            }
            
            return $fields;
            
        }
        
        $md = $this->getMetaData();
        
        $fields = array();
        
        foreach ($md->fieldMappings as $field) {
            $fields[] = $alias.'.'.$field['fieldName'];
        }
        
        return $fields;
        
    }

    public function setItemListActions(Array $actions){
        
        foreach($actions as $action){
            
            if($this->getAdmin()->hasAction($action)){
                
                $this->itemListActions[$action] = $this->getAdmin()->getRoute($action);
                
            }
            
        }
    }
    
    public function getItemListActions(){
        
        return $this->itemListActions;
    }
    
    public function setListActions(Array $actions){
        
        foreach($actions as $action){
            
            if($this->getAdmin()->hasAction($action)){
                
                $this->listActions[$action] = $this->getAdmin()->getRoute($action);
                
            }
            
        }
    }
    
    public function getListActions(){
        
        return $this->listActions;
    }  
}