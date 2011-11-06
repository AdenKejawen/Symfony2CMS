<?php


namespace CMS\System\Bundle\ImageBundle\Twig\Extension;

use Avalanche\Bundle\ImagineBundle\Templating\ImagineExtension as AvalancheImagineExtension;

class ImageExtension extends AvalancheImagineExtension
{
    /**
     * (non-PHPdoc)
     * @see Twig_Extension::getFilters()
     */
    public function getFilters()
    {
        return array(
            'cms_image_cache' => new \Twig_Filter_Method($this, 'applyFilter'),
        );
    }

    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'cms_image';
    }
}
