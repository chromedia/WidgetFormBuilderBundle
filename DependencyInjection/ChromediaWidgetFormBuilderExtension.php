<?php

namespace Chromedia\WidgetFormBuilderBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ChromediaWidgetFormBuilderExtension extends Extension
{

    public function getInternalAlias()
    {
        return '_cwfb';
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('forms.yml');

        $widgets = $config['widgets'];

        // create _cwfb.widget_selection_choices parameter
        $widgetSelectionChoices = array();
        foreach ($widgets as $widgetId => $widgetData) {
            $widgetSelectionChoices[$widgetId] = $widgetData['name'];
        }
        $container->setParameter($this->getInternalAlias().'.widget_selection_choices', $widgetSelectionChoices);
    }
}
