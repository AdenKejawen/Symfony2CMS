<?php

namespace CMSDoctrineExt\Mapping\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * File annotation for File behavioral extension
 *
 * @Annotation
 * 
 * @author GrifiS
 * @package CMSDoctrineExt.Mapping.Annotation
 * @subpackage File
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * 
 */

final class File extends Annotation
{
    public $dir = 'files';
}

