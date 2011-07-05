<?php

namespace CMSDoctrineExt\File\Mapping\Driver;

use Gedmo\Mapping\Driver\AnnotationDriverInterface;
use Gedmo\Exception\InvalidMappingException;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use CMS\System\Bundle\CoreBundle\Services\Core as CMSCore;

class Annotation implements AnnotationDriverInterface
{
    /**
     * Annotation field is File
     */
    const FileAnnotation = 'CMSDoctrineExt\\Mapping\\Annotation\\File';


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
        foreach ($class->getProperties() as $property) {
            if ($meta->isMappedSuperclass && !$property->isPrivate() ||
                $meta->isInheritedField($property->name) ||
                isset($meta->associationMappings[$property->name]['inherited'])
            ) {
                continue;
            }
            if ($file = $this->reader->getPropertyAnnotation($property, self::FileAnnotation)) {

                $field = $property->getName();
                $value = $file->dir;
                        
                if (!$meta->hasField($field)) {
                    throw new InvalidMappingException("Unable to find timestampable [{$field}] as mapped property in entity - {$meta->name}");
                }
                
                $config['field'] = $field;
                $config['dir'] = CMSCore::init()->getUploadsDir().'/'.$value;
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