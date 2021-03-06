<?php
namespace Chromedia\WidgetFormBuilderBundle\Service;

use Symfony\Component\Form\FormFactory as CoreFormFactory;
use Chromedia\WidgetFormBuilderBundle\DependencyInjection\Core\CoreWidgets;
use Chromedia\WidgetFormBuilderBundle\Exception\FieldTypeFactoryException;

/**
 *
 * @author Allejo Chris G. Velarde
 *
 */

class FieldTypeFactory
{
    /**
     * @var CoreFormFactory
     */
    private $coreFormFactory;

    private $availableConstraints;

    private $availableWidgets;

    private $widgetTransformers;

    private $ownedTransformers;


    public function setCoreFormFactory(CoreFormFactory $v)
    {
        $this->coreFormFactory = $v;
    }

    public function setAvailableConstraints($v)
    {
        $this->availableConstraints = $v;
    }

    public function setAvailableWidgets($v)
    {
        $this->availableWidgets = $v;
    }

    public function setWidgetTransformers($v)
    {
        $this->widgetTransformers = $v;
    }

    public function setServiceContainer($v)
    {
        $this->container = $v;
    }




    /**
     *
     * @param unknown $name
     * @param array $widgetMetadata
     * @param string $formData
     * @throws \Exception
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function createFieldTypeFromWidgetMetadata($name, array $widgetMetadata=array(), $formData=null, array $formOptions=array())
    {
        $required = array('widget_id');

        foreach ($required as $property) {
        	if (!isset($widgetMetadata[$property])) {
        		throw new \Exception(__CLASS__.':createFieldTypeFromWidgetMetadata missing required metadata key ['.$property.']');
        	}
        }

        $this->ownedTransformers = isset($this->widgetTransformers[$widgetMetadata['widget_id']]) ? 
                                        $this->widgetTransformers[$widgetMetadata['widget_id']] : 
                                        array();

        // build form choices
        $this
            ->buildWidget($widgetMetadata, $formOptions)
            ->buildWidgetChoices($widgetMetadata, $formOptions)
            ->buildWidgetAttributes($widgetMetadata, $formOptions)
            ->buildWidgetOptions($widgetMetadata, $formOptions)
            ->buildConstraints($widgetMetadata, $formOptions)
        ;

        $fieldType = $this->coreFormFactory->createNamedBuilder($name, $widgetMetadata['widget_id'], $formData, $formOptions);

        $this->addTransformers($this->ownedTransformers, $fieldType);

        return $fieldType;
    }

    /**
     *
     */
    private function buildWidget(&$widgetMetadata, &$formOptions)
    {
        if (!array_key_exists($widgetMetadata['widget_id'], $this->availableWidgets)) {
            throw FieldTypeFactoryException::widgetIdUnavailable($widgetMetadata['widget_id']);
        }

        $widget = $this->availableWidgets[$widgetMetadata['widget_id']];

        if ($widget) {
            if ($widget['with_choices']) {
                switch($widgetMetadata['widget_id']) {
                    case 'radio':
                        $formOptions['expanded'] = true;
                        $formOptions['multiple'] = false;
                        break;
                    case 'checkbox':
                        $formOptions['expanded'] = true;
                        $formOptions['multiple'] = true;
                        break;
                }

                $widgetMetadata['widget_id'] = 'choice';
            }
        }

        return $this;
    }

    /**
     *
     * @param unknown $widgetMetadata
     * @param unknown $formOptions
     * @return \Chromedia\WidgetFormBuilderBundle\Service\FieldTypeFactory
     */
    private function buildWidgetChoices($widgetMetadata, &$formOptions)
    {
        if (!array_key_exists($widgetMetadata['widget_id'], $this->availableWidgets)) {
            throw FieldTypeFactoryException::widgetIdUnavailable($widgetMetadata['widget_id']);
        }

        $widget = $this->availableWidgets[$widgetMetadata['widget_id']];
        if ($widget) {
            if ($widget['with_choices']) {
                $formOptions['choices'] = $widgetMetadata['widget_choices'];
            }
        }

        return $this;
    }

    /**
     *
     * @param unknown $widgetMetadata
     * @param unknown $formOptions
     * @return \Chromedia\WidgetFormBuilderBundle\Service\FieldTypeFactory
     */
    private function buildWidgetAttributes($widgetMetadata, &$formOptions)
    {
        $attr = (isset($formOptions['attr']) && count($formOptions['attr'])) ? $formOptions['attr'] : array();
        foreach ($widgetMetadata['widget_attribute'] as $key => $data) {
            $attr = array_merge($attr, $data);
        }
        $formOptions['attr'] = $attr;

        return $this;
    }

    /**
     *
     * @param array $widgetMetadata
     * @param array $formOptions
     * @return \Chromedia\WidgetFormBuilderBundle\Service\FieldTypeFactory
     */
    private function buildConstraints($widgetMetadata, &$formOptions)
    {
        $constraints = array();
        foreach ($widgetMetadata['widget_constraints'] as $constraintData) {
            if (isset($constraintData['constraint_id'])) {
                if (isset($this->availableConstraints[$constraintData['constraint_id']])) {
                    $class = $this->availableConstraints[$constraintData['constraint_id']]['class'];
                    $constraintObj = new $class($constraintData['constraint_options']);

                    $constraints[] = $constraintObj;
                }
                else {
                    throw new \Exception('Unknown Constraint: '.$constraintData['constraint_id']);
                }
            }
        }

        $formOptions['constraints'] = $constraints;

        return $this;
    }

    /**
     *
     * @param array $widgetMetadata
     * @param array $formOptions
     * @return \Chromedia\WidgetFormBuilderBundle\Service\FieldTypeFactory
     */
    private function buildWidgetOptions($widgetMetadata, &$formOptions)
    {
        $setOptions = isset($widgetMetadata['widget_config_options']) ? $widgetMetadata['widget_config_options'] : array();


        // TODO: validate set options
        try {
            foreach($setOptions as $option) {
                foreach ($option as $key => $item) {
                    if (strlen($key) && !is_null($item)){
                        $formOptions[$key] = $item;
                    }
                }
                //$formOptions = array_merge($formOptions, $option);
            }
        } catch(\Exception $e) {
            throw new \Exception('An invalid field configuration was set.');
        }

        return $this;
    }

    /**
     * Adds transformers
     */
    private function addTransformers($transformers, &$fieldType)
    {
        foreach ($transformers as $key => $transformer) {
            if (!empty($transformer)) {
                switch ($key) {
                    case 'model':
                        $fieldType->addModelTransformer($this->container->get($transformer));
                        break;

                    case 'view':
                        $fieldType->addViewTransformer($this->container->get($transformer));
                        break;
                }
            }
        }

        return $this;
    }
}