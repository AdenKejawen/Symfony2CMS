<?php

namespace CMSDoctrineExt\Mapping\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Slug annotation for Sluggable behavioral extension
 *
 * @Annotation
 *
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
final class Slug extends Annotation
{
    public $updatable = false;
    public $unique = true;
    public $separator = '-';
}

