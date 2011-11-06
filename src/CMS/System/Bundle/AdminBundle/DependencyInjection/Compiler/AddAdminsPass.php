<?php

namespace CMS\System\Bundle\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
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
            ))->addMethodCall('setUniqueName', array($uniqueName))->addMethodCall('defaultConfigure');
            
            if($tag[0]['crud'] === true){
                
                $container->getDefinition($serviceId)->addMethodCall('addAction', array('list', new Reference('cms_admin.action.list')));
                
                $container->getDefinition($serviceId)->addMethodCall('addAction', array('new', new Reference('cms_admin.action.new')));
                
                $container->getDefinition($serviceId)->addMethodCall('addAction', array('edit', new Reference('cms_admin.action.edit')));
                
                /*
                $definitionForActionList = $container->register($serviceId.'.action.list', 'CMS\\System\\Bundle\\AdminBundle\\Admin\\Action\\ListAction');
                
                $definitionForActionList->addTag('cms_admin.action');
                
                $container->getDefinition($serviceId)->addMethodCall('addAction', array('list', new Reference($serviceId.'.action.list')));
                
                $definitionForActionNew = $container->register($serviceId.'.action.new', 'CMS\\System\\Bundle\\AdminBundle\\Admin\\Action\\NewAction');
                
                $definitionForActionList->addTag('cms_admin.action');
                
                $definitionForActionNew->addMethodCall('setPattern', array('/new'));
                
                $container->getDefinition($serviceId)->addMethodCall('addAction', array('new', new Reference($serviceId.'.action.new')));
                
                $definitionForActionEdit = $container->register($serviceId.'.action.edit', 'CMS\\System\\Bundle\\AdminBundle\\Admin\\Action\\EditAction');
                
                $definitionForActionList->addTag('cms_admin.action');
                
                $definitionForActionEdit->addMethodCall('setPattern', array('/{id}/edit'));
                
                $container->getDefinition($serviceId)->addMethodCall('addAction', array('edit', new Reference($serviceId.'.action.edit')));
                */
               
               
            }
            
            $container->getDefinition($serviceId)->addMethodCall('configure');
            
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
