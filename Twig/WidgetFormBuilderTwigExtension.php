<?php
namespace Chromedia\WidgetFormBuilderBundle\Twig;

class WidgetFormBuilderTwigExtension extends \Twig_Extension
{
    private $constraintFlattenedOptions;

    public function getName()
    {
        return 'chromedia_widget_form_builder_twig_extension';
    }

    public function setConstraintFlattenedOptions($v)
    {
        $this->constraintFlattenedOptions = $v;
    }

    public function getGlobals()
    {
        return array(
        	'cwfb_widget_constraint_flattened_options' => $this->constraintFlattenedOptions
        );
    }
}