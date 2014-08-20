<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AvailableWidgetChoiceFieldType extends AbstractType
{
    private $defaultChoices;

    private $configOptions;

    private $widgetConfigOptions;

    public function getName()
    {
        return 'chromedia_available_widget_choice';
    }

    public function setChoices($choices)
    {
        $this->defaultChoices = $choices;
    }

    public function setWidgetConfigOptions($v)
    {
        $this->widgetConfigOptions = $v;
    }

    public function getParent()
    {
        return 'choice';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->defaultChoices,
            'attr'    => array('widget-options' => \json_encode($this->widgetConfigOptions))
        ));
    }
}