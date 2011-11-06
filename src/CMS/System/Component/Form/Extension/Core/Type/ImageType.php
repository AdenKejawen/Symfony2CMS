<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CMS\System\Component\Form\Extension\Core\Type;

use CMS\System\Component\Form\Extension\Core\Type\FileType;

class ImageType extends FileType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'image';
    }
}
