<?php

namespace CMSDoctrineExt\File\Mapping\Event\Adapter;

use Gedmo\Mapping\Event\Adapter\ORM as BaseAdapterORM;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use CMSDoctrineExt\File\Mapping\Event\FileAdapter;

/**
 * Doctrine event adapter for ORM adapted
 * for Timestampable behavior
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @package Gedmo\Timestampable\Mapping\Event\Adapter
 * @subpackage ORM
 * @link http://www.gediminasm.org
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
final class ORM extends BaseAdapterORM implements FileAdapter
{
    /**
     * {@inheritDoc}
     */
    public function generateFileName(ClassMetadata $meta, UploadedFile $file, $i = null)
    {
        return (strtotime('now')+$i) . '.' . $file->guessExtension();
    }
}