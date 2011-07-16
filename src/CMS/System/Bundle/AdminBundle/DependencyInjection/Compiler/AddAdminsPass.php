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
            
            if($tag[0]['crud'] === true){
                
                $container->getDefinition($serviceId)->addMethodCall('addAction', array('list', new Reference('cms_admin.action.list')));
                
                $container->getDefinition($serviceId)->addMethodCall('addAction', array('new', new Reference('cms_admin.action.new')));
                
                $container->getDefinition($serviceId)->addMethodCall('addAction', array('edit', new Reference('cms_admin.action.edit')));
            }
            
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
