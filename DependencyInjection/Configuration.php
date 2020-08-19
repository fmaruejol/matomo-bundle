<?php

namespace Fmaruejol\Bundle\MatomoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('fmaruejol_matomo');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('fmaruejol_matomo');
        }

        $rootNode
            ->children()
            ->scalarNode('disabled')->defaultValue('%kernel.debug%')->end()
            ->scalarNode('matomo_host')->isRequired()->end()
            ->scalarNode('site_id')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
