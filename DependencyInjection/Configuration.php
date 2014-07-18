<?php

namespace Chromedia\WidgetFormBuilderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('chromedia_widget_form_builder');

        // add widgets option
        $this->addWidgets($rootNode);


        return $treeBuilder;
    }

    private function addWidgets(ArrayNodeDefinition $node)
    {
        // TODO: validate widget keys
        $widgets = $node->children()
            ->arrayNode('widgets')
                ->prototype('array')
                    ->children()
                        ->scalarNode('name')
                            ->isRequired()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }

    private function createCoreWidget()
    {
        $treeBuilder = new TreeBuilder();

        $root = $treeBuilder->root('choice');

        $root->children()
            ->scalarNode('name')
            ->end();

        return $root;


    }
}
