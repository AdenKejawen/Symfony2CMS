<?php

namespace CMSDoctrineExt\Mapping\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Demo annotation for Demo behavioral extension
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @package Gedmo.Mapping.Annotation
 * @subpackage Demo
 * @link http://www.gediminasm.org
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
final class Demo extends Annotation
{
    public $text = 'tux';
}

