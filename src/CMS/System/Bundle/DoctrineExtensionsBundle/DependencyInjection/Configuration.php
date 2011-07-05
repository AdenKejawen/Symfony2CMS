<?php

namespace CMS\System\Bundle\DoctrineExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cms_doctrine_extensions');

        $rootNode
            ->append($this->getVendorNode('orm'))
            ->append($this->getVendorNode('mongodb'))
            ->append($this->getClassNode())
            ->end()
        ;

        return $treeBuilder;
    }

    private function getVendorNode($name)
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root($name);

        $node
            ->useAttributeAsKey('id')
            ->prototype('array')
                ->performNoDeepMerging()
                ->children()
                    ->scalarNode('demo')->defaultTrue()->end()
                    ->scalarNode('file')->defaultTrue()->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    private function getClassNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('class');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('demo')
                    ->cannotBeEmpty()
                    ->defaultValue('CMSDoctrineExt\\Demo\\DemoListener')
                ->end()
                ->scalarNode('file')
                    ->cannotBeEmpty()
                    ->defaultValue('CMSDoctrineExt\\File\\FileListener')
                ->end()
            ->end()
        ;

        return $node;
    }
}

