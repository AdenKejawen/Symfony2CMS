<?php

namespace CMSDoctrineExt\Mapping\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Sluggable annotation for Sluggable behavioral extension
 *
 * @Annotation
 *
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
final class Sluggable extends Annotation
{
    public $position = 0;
}

