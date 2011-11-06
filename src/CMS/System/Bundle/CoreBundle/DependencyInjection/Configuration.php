<?php

namespace CMS\System\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cms_core');

        $rootNode
            ->children()
                ->scalarNode('upload_dir')->defaultValue('%assetic.read_from%/uploads')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}