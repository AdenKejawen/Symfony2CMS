<?php

namespace CMS\System\Bundle\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AddAdminRoutePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('cms_admin.admin') as $serviceId => $tag) {
            
            $container->getDefinition($serviceId)->addMethodCall('registerRoutesForActions');
            
        }


    }
   
}
