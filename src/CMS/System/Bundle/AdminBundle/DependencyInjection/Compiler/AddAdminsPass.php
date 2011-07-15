<?php

namespace CMS\System\Bundle\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class AddAdminsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('cms_admin.admin_pool')) {
            return;
        }

        $adminsIds = array();

        foreach ($container->findTaggedServiceIds('cms_admin.admin') as $serviceId => $tag) {

            $uniqueName = $this->createUniqueName($serviceId);
            
            $container->getDefinition($serviceId)->addMethodCall('setContainer', array(
                new Reference('service_container'),
            ))->addMethodCall('setUniqueName', array($uniqueName))->addMethodCall('defaultConfigure')->addMethodCall('configure');
            
            $adminsIds[$this->createUniqueName($serviceId)] = $serviceId;
        }

        $container->getDefinition('cms_admin.admin_pool')->replaceArgument(0, $adminsIds);

    }
    
    public function createUniqueName($serviceId){
        
        $name = str_replace('cms_admin.', '', $serviceId);
        
        $name = str_replace(array('.', '_'), '-', $name);
        
        return $name;
    }
}
