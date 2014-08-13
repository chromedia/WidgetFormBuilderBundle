<?php
namespace Chromedia\WidgetFormBuilderBundle\Service;

use Symfony\Component\Form\FormFactory as CoreFormFactory;
use Chromedia\WidgetFormBuilderBundle\DependencyInjection\Core\CoreWidgets;

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

    public function setCoreFormFactory(CoreFormFactory $v)
    {
        $this->coreFormFactory = $v;
    }

    public function setAvailableConstraints($v)
    {
        $this->availableConstraints = $v;
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
        // build form choices
        $this
            ->buildWidgetChoices($widgetMetadata, $formOptions)
            ->buildWidgetAttributes($widgetMetadata, $formOptions)
            ->buildConstraints($widgetMetadata, $formOptions)
        ;

        $fieldType = $this->coreFormFactory->createNamedBuilder($name, $widgetMetadata['widget_id'], $formData, $formOptions);

        return $fieldType;
    }

    /**
     *
     * @param unknown $widgetMetadata
     * @param unknown $formOptions
     * @return \Chromedia\WidgetFormBuilderBundle\Service\FieldTypeFactory
     */
    private function buildWidgetChoices($widgetMetadata, &$formOptions)
    {
        // FIXME: This only checks for core widgets, also add the custom widgets
        $coreWidget = CoreWidgets::get($widgetMetadata['widget_id']);
        if ($coreWidget) {
            if ($coreWidget['with_choices']) {
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
        $attr = array();
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
            if (isset($this->availableConstraints[$constraintData['constraint_id']])) {
                $class = $this->availableConstraints[$constraintData['constraint_id']]['class'];
                $constraintObj = new $class($constraintData['constraint_options']);

                $constraints[] = $constraintObj;
            }
            else {
                throw new \Exception('Unknown Constraint: '.$constraintData['constraint_id']);
            }
        }

        $formOptions['constraints'] = $constraints;

        return $this;
    }
}