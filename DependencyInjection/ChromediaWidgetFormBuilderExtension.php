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

        $coreWidgets = $config['core_widgets'];

        // create _cwfb.widget_selection_choices parameter
        $widgetSelectionChoices = array();
        $availableWidgets = array();
        $widgetConfigOptions = array();
        $transformers = array();

        foreach ($coreWidgets as $widgetId => $widgetData) {
            $widgetSettings = $widgetData['settings'];
            if ($widgetSettings && !$widgetSettings['in_widget_list']) {
                continue;
            }
            $widgetSelectionChoices[$widgetId] = $widgetData['name'];
            $availableWidgets[$widgetId] = $widgetData;
            $widgetConfigOptions[$widgetId] = $widgetData['options'];
            if (isset($widgetData['transformer'])) {
                $transformers[$widgetId] = $widgetData['transformer'];
            }
        }

        // add custom widgets to selection
        foreach ($config['custom_widgets'] as $widgetId => $widgetData) {
            $widgetSelectionChoices[$widgetId] = $widgetData['name'];
            $widgetData['internal'] = false; // always set to false
            $availableWidgets[$widgetId] = $widgetData;
            if (isset($widgetData['transformer'])) {
                $transformers[$widgetId] = $widgetData['transformer'];
            }
        }

        $container->setParameter($this->getInternalAlias().'.widget_selection_choices', $widgetSelectionChoices);
        $container->setParameter($this->getInternalAlias().'.widget_config_options', $widgetConfigOptions);
        $container->setParameter($this->getInternalAlias().'.available_widgets', $availableWidgets);
        $container->setParameter($this->getInternalAlias().'.widget_transformers', $transformers);

        // process constraints and create _cwfb.widget_constraint_choices
        $widgetConstraintChoices = array();
        $widgetFlatConstraintOptions = array();
        $coreConstraints = array();

        if (isset($config['core_constraints'])) {
            $coreConstraints = $config['core_constraints'];

            foreach ($coreConstraints as $id => &$constraintData) {
                $widgetConstraintChoices[$id] = $constraintData['name'];
                $obj = new \ReflectionClass($constraintData['class']);
                $options = $obj->getDefaultProperties();
                unset($options['groups']);
                $constraintData['options'] = array_keys($options);
                $widgetFlatConstraintOptions[$id] = $constraintData['options'];
            }
        }

        // _cwfb.constraints_availability status
        $container->setParameter($this->getInternalAlias().'.constraints_availability', !empty($coreConstraints));

        // _cwfb.widget_constraint_choices will be used in the dropdown for selecting a constraint
        $container->setParameter($this->getInternalAlias().'.widget_constraint_choices', $widgetConstraintChoices);

        // _cwfb.widget_constraints
        $container->setParameter($this->getInternalAlias().'.widget_constraints', $coreConstraints);

        // _cwfb.widget_flat_constraint_options
        $container->setParameter($this->getInternalAlias().'.widget_flat_constraint_options', $widgetFlatConstraintOptions);

        // _cwfb.form_template
        $container->setParameter($this->getInternalAlias().'.form_template', $config['form_template']);
    }
}
