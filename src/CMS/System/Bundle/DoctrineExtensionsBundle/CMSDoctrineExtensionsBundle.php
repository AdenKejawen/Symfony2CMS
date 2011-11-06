<?php

namespace CMS\System\Bundle\DoctrineExtensionsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CMS\System\Bundle\DoctrineExtensionsBundle\DependencyInjection\Compiler\ValidateExtensionConfigurationPass;

class CMSDoctrineExtensionsBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ValidateExtensionConfigurationPass());
    }
}
