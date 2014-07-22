<?php

namespace Chromedia\WidgetFormBuilderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Yaml\Yaml;
use Chromedia\WidgetFormBuilderBundle\DependencyInjection\Core\CoreWidgets;

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
        $this->addCoreWidgets($rootNode);

        // add custom widgets option
        $this->addCustomWidgets($rootNode);

        $rootNode->children()
            ->scalarNode('form_template')
                ->defaultValue("ChromediaWidgetFormBuilderBundle:Form:form_template.html.twig")
                ->cannotBeEmpty()
            ->end()
        ->end();

        return $treeBuilder;
    }

    private function addCoreWidgets(ArrayNodeDefinition $node)
    {
        $coreWidgets = $node->children()->arrayNode('core_widgets');
        foreach (CoreWidgets::all() as $widgetId => $widgetProperty) {
            $coreWidgets->append($this->createCoreWidget($widgetId, $widgetProperty));
        }
        $coreWidgets->end();
    }

    private function addCustomWidgets(ArrayNodeDefinition $node)
    {
        $node
        ->children()
            ->arrayNode('custom_widgets')
                ->prototype('array')
                    ->children()
                        ->scalarNode('name')
                            ->isRequired()
                        ->end()
                        ->scalarNode('parent_id')
                            ->isRequired()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }

    private function createCoreWidget($widgetId, $widgetProperty)
    {
        $treeBuilder = new TreeBuilder();

        $root = $treeBuilder->root($widgetId);

        $root->children()
            ->scalarNode('name')
                ->defaultValue($widgetProperty['name'])
            ->end()
            // this should be an internal option and should not be overwritten
            ->booleanNode('with_choices')
                ->defaultValue($widgetProperty['with_choices'])
            ->end()
            // this should be an internal option and should not be overwritten
            ->booleanNode('internal')
                ->defaultTrue()
            ->end()
        ->end();

        return $root;


    }
}