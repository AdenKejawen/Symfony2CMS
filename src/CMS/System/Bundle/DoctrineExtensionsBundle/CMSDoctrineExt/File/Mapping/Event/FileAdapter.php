<?php

namespace CMSDoctrineExt\File\Mapping\Event;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Event\AdapterInterface;

/**
 * Doctrine event adapter interface
 * for Timestampable behavior
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @package Gedmo\Timestampable\Mapping\Event
 * @subpackage TimestampableAdapter
 * @link http://www.gediminasm.org
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
interface FileAdapter extends AdapterInterface
{
    /**
     * Get the date value
     *
     * @param ClassMetadata $meta
     * @param string $field
     * @return mixed
     */
    function generateFileName(ClassMetadata $meta, UploadedFile $file, $i = null);
}