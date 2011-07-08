<?php

namespace CMSDoctrineExt\File\Mapping\Driver;

use Gedmo\Mapping\Driver\AnnotationDriverInterface;
use Gedmo\Exception\InvalidMappingException;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use CMS\System\Bundle\CoreBundle\Services\Core as CMSCore;

class Annotation implements AnnotationDriverInterface
{

    const FILE = 'CMSDoctrineExt\\Mapping\\Annotation\\File';
    
    const FILE_DELETE = 'CMSDoctrineExt\\Mapping\\Annotation\\FileDelete';


    /**
     * Annotation reader instance
     *
     * @var object
     */
    private $reader;

    /**
     * original driver if it is available
     */
    protected $_originalDriver = null;

    /**
     * {@inheritDoc}
     */
    public function setAnnotationReader($reader)
    {
        $this->reader = $reader;
    }

    /**
     * {@inheritDoc}
     */
    public function validateFullMetadata(ClassMetadata $meta, array $config) {}

    /**
     * {@inheritDoc}
     */
    public function readExtendedMetadata(ClassMetadata $meta, array &$config) {
        $class = $meta->getReflectionClass();
        // property annotations
        
        $config['fields'] = array();
        
        $config['fields_delete'] = array();
        
        foreach ($class->getProperties() as $property) {
            if ($meta->isMappedSuperclass && !$property->isPrivate() ||
                $meta->isInheritedField($property->name) ||
                isset($meta->associationMappings[$property->name]['inherited'])
            ) {
                continue;
            }
            
            $field = null;
            
            if ($file = $this->reader->getPropertyAnnotation($property, self::FILE)) {

                $field['name'] = $property->getName();
                $field['dir'] = CMSCore::init()->getUploadsDir().'/'.$file->dir;
                        
                if (!$meta->hasField($field['name'])) {
                    throw new InvalidMappingException("Unable to find timestampable [{$field}] as mapped property in entity - {$meta->name}");
                }
                

            }
            
            // if ($fileDelete = $this->reader->getPropertyAnnotation($property, self::FILE_DELETE)) {
//                 
                // $config['fields_delete'][] = $property->getName();
//                 
            // }
            
            if($field){
                
               $config['fields'][] = $field; 
                
            }
            
        }
        
    }

    /**
     * Passes in the mapping read by original driver
     *
     * @param $driver
     * @return void
     */
    public function setOriginalDriver($driver)
    {
        $this->_originalDriver = $driver;
    }
}