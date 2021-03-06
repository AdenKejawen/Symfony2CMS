<?php

namespace CMSDoctrineExt\Demo\Mapping\Event\Adapter;

use Gedmo\Mapping\Event\Adapter\ORM as BaseAdapterORM;
use CMSDoctrineExt\Demo\Mapping\Event\DemoAdapter;

/**
 * Doctrine event adapter for ORM adapted
 * for Timestampable behavior
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @package Gedmo\Demo\Mapping\Event\Adapter
 * @subpackage ORM
 * @link http://www.gediminasm.org
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
final class ORM extends BaseAdapterORM implements DemoAdapter
{
    /**
     * {@inheritDoc}
     */
    public function getDateValue($meta, $field)
    {
        return new \DateTime();
    }
}