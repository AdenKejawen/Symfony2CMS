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
            
            $this->_files[$config['field']] = $meta->getReflectionProperty($config['field'])->getValue($object);
            
            if(isset($this->_files[$config['field']]) and $this->_files[$config['field']] instanceof UploadedFile)
                $meta->getReflectionProperty($config['field'])->setValue($object, strtotime('now') . '.' . $this->_files[$config['field']]->guessExtension());
        }
    }
    
    public function postPersist(EventArgs $args)
    {
        $ea = $this->getEventAdapter($args);
        $om = $ea->getObjectManager();
        $object = $ea->getObject();
        
        $meta = $om->getClassMetadata(get_class($object));
        
        if ($config = $this->getConfiguration($om, $meta->name)) {
            
            if(isset($this->_files[$config['field']]) and$this->_files[$config['field']] instanceof UploadedFile) {
    
                $file_name = $meta->getReflectionProperty($config['field'])->getValue($object);
                
                $this->_files[$config['field']]->move($config['dir'], $file_name);
    
                unset($this->_files[$config['field']]);
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
            
            $this->_files[$config['field']] = $meta->getReflectionProperty($config['field'])->getValue($object);
            
            if(isset($this->_files[$config['field']]) and $this->_files[$config['field']] instanceof UploadedFile) {
                
                $args->setNewValue($config['field'], strtotime('now') . '.' . $this->_files[$config['field']]->guessExtension());
                
                $meta->getReflectionProperty($config['field'])->setValue($object, $args->getNewValue($config['field']));
                
                if($args->getOldValue($config['field']))
                    $this->removeUploadedFile($config['dir'].'/'.$args->getOldValue($config['field']));
                
            } else {
                
                $args->setNewValue($config['field'], $args->getOldValue($config['field']));
                
                $meta->getReflectionProperty($config['field'])->setValue($object, $args->getOldValue($config['field']));
                
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
            
            if(isset($this->_files[$config['field']]) and $this->_files[$config['field']] instanceof UploadedFile) {
    
                $file_name = $meta->getReflectionProperty($config['field'])->getValue($object);
                
                $this->_files[$config['field']]->move($config['dir'], $file_name);
    
                unset($this->_files[$config['field']]);
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
