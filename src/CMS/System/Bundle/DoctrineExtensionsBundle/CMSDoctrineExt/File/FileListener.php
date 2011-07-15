<?php

namespace CMSDoctrineExt\File;

use Doctrine\Common\EventArgs;
use Gedmo\Mapping\MappedEventSubscriber;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * The Timestampable listener handles the update of
 * dates on creation and update.
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @package Gedmo.Demo
 * @subpackage DemoListener
 * @link http://www.gediminasm.org
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class FileListener extends MappedEventSubscriber
{
    protected $_files = array();
    
    /**
     * Specifies the list of events to listen
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'loadClassMetadata',
            'postLoad',
            'prePersist',
            'postPersist',
            'preUpdate',
            'postUpdate',
            'postRemove'
        );
    }
    

    /**
     * Mapps additional metadata for the Entity
     *
     * @param EventArgs $eventArgs
     * @return void
     */
    public function loadClassMetadata(EventArgs $eventArgs)
    {
        $ea = $this->getEventAdapter($eventArgs);
        $this->loadMetadataForObjectClass($ea->getObjectManager(), $eventArgs->getClassMetadata());
    }
    
    public function postLoad(EventArgs $args)
    {
        $ea = $this->getEventAdapter($args);
        $om = $ea->getObjectManager();
        $object = $ea->getObject();
        
        $meta = $om->getClassMetadata(get_class($object));
        
    }

    /*
     *
     * @param EventArgs $args
     * @return void
     */
    public function prePersist(EventArgs $args)
    {
        $ea = $this->getEventAdapter($args);
        $om = $ea->getObjectManager();
        $object = $ea->getObject();

        $meta = $om->getClassMetadata(get_class($object));
        
        if ($config = $this->getConfiguration($om, $meta->name)) {
            
            if(isset($config['fields'])){
                
                foreach($config['fields'] as $field){
                    
                    $field_name = $field['name'];
                    
                    $this->_files[$field_name] = $meta->getReflectionProperty($field_name)->getValue($object);
            
                    if(isset($this->_files[$field_name]) and $this->_files[$field_name] instanceof UploadedFile)
                    $meta->getReflectionProperty($field_name)->setValue($object, strtotime('now') . '.' . $this->_files[$field_name]->guessExtension());
                    
                }
                
            }
        }
    }
    
    public function postPersist(EventArgs $args)
    {
        $ea = $this->getEventAdapter($args);
        $om = $ea->getObjectManager();
        $object = $ea->getObject();
        
        $meta = $om->getClassMetadata(get_class($object));
        
        if ($config = $this->getConfiguration($om, $meta->name)) {
            
            if(isset($config['fields'])){
                
                foreach($config['fields'] as $field){
                    
                    $field_name = $field['name'];
                    
                    if(isset($this->_files[$field_name]) and $this->_files[$field_name] instanceof UploadedFile) {
    
                        $file_name = $meta->getReflectionProperty($field_name)->getValue($object);
                
                        $this->_files[$field_name]->move($field['dir'], $file_name);
    
                        unset($this->_files[$field_name]);
                    }
                    
                }
                
            }
        }
    }
    
    public function preUpdate(EventArgs $args)
    {
        $ea = $this->getEventAdapter($args);
        $om = $ea->getObjectManager();
        $object = $ea->getObject();

        $meta = $om->getClassMetadata(get_class($object));
        
        if ($config = $this->getConfiguration($om, $meta->name)) {
            
            if(isset($config['fields'])){
                $test = array();
                $i = 0;
                foreach($config['fields'] as $field){
                    
                    $field_name = $field['name'];
            
                    $this->_files[$field_name] = $meta->getReflectionProperty($field_name)->getValue($object);
                    
                    if(isset($this->_files[$field_name]) and $this->_files[$field_name] instanceof UploadedFile) {
                        
                        $file_name = $ea->generateFileName($meta, $this->_files[$field_name], $i++);
                        
                        $args->setNewValue($field_name, $file_name);
                        
                        $meta->getReflectionProperty($field_name)->setValue($object, $file_name);
                        
                        if($args->getOldValue($field_name))
                            
                            $this->removeUploadedFile($field['dir'].'/'.$args->getOldValue($field_name));
                        
                    } else {
                        
                        
                        if ($args->hasChangedField($field_name)) {
                            
                           $args->setNewValue($field_name, $args->getOldValue($field_name));
                        
                           $meta->getReflectionProperty($field_name)->setValue($object, $args->getOldValue($field_name));
                           
                        } 
                            
                        $file_delete = $field['name'].'_delete';
                        
                        $old_value = $meta->getReflectionProperty($field_name)->getValue($object);
                    
                        if(isset($object->$file_delete) and ($object->$file_delete == true) and ($old_value != '' or $old_value != null)){
                            
                           $this->removeUploadedFile($field['dir'].'/'.$old_value);
                            
                           $args->setNewValue($field_name, null);
                           
                           $object->$file_delete = false;
                            
                        }
                       
                    }
                    
                }
                
            }
        }
        
    }
    
    public function postUpdate(EventArgs $args)
    {
        $ea = $this->getEventAdapter($args);
        $om = $ea->getObjectManager();
        $object = $ea->getObject();
        
        $meta = $om->getClassMetadata(get_class($object));
        
        if ($config = $this->getConfiguration($om, $meta->name)) {
            
            if(isset($config['fields'])){
                
                foreach($config['fields'] as $field){
                    
                    $field_name = $field['name'];
            
                    if(isset($this->_files[$field_name]) and $this->_files[$field_name] instanceof UploadedFile) {
            
                        $file_name = $meta->getReflectionProperty($field_name)->getValue($object);
                        
                        $test[] = $file_name;
                        
                        $this->_files[$field_name]->move($field['dir'], $file_name);
            
                        unset($this->_files[$field_name]);
                        
                    }
                    
                }
                
            }
        }
    }

    public function postRemove(EventArgs $args)
    {
        $ea = $this->getEventAdapter($args);
        $om = $ea->getObjectManager();
        $object = $ea->getObject();
        
        $meta = $om->getClassMetadata(get_class($object));
        
        if ($config = $this->getConfiguration($om, $meta->name)) {
            
            if(isset($config['fields'])){
                
                foreach($config['fields'] as $field){
                    
                    $field_name = $field['name'];
                    
                    $file_name = $meta->getReflectionProperty($field_name)->getValue($object);
                    
                    if($file_name != null)
                        $this->removeUploadedFile($field['dir'].'/'.$file_name);
                }
                
            }
        }
    }
    
    public function removeUploadedFile($file) {
        if(file_exists($file)) {
            unlink($file);
        }
    }
    

    /**
     * {@inheritDoc}
     */
    protected function getNamespace()
    {
        return __NAMESPACE__;
    }
}
