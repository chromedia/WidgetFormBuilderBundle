<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Chromedia\WidgetFormBuilderBundle\Form\Transformer\JsonMetadataTransformer;



class WidgetBuilderFormType extends AbstractType
{
    const NAME = 'chromedia_widget_builder_form_type';

    private $hasConstraints = true;

    public function getName()
    {
        return self::NAME;
    }

    public function setConstraintsAvailabilty($hasConstraints = true)
    {
        $this->hasConstraints = $hasConstraints;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // will either be a core_widge or a custom_widget listed in core_widgets or custom_widgets configuration
        $builder->add('widget_id', 'chromedia_available_widget_choice');

        $builder->add('widget_config_options', 'collection', array(
            'type' => 'chromedia_widget_config_option',
            'allow_add' => true,
            'required' => false
        )); 

        $builder->add('widget_choices', 'collection', array(
            'type'      => 'chromedia_widget_choice',
            'allow_add' => true
        ));

        $builder->add('widget_attribute', 'collection', array(
        	'type' => 'chromedia_widget_attribute',
            'allow_add' => true
        )); 

        $widgetConstraintOpt = array(
            'type' => 'chromedia_widget_constraint',
            'allow_add' => true
        );

        if (!$this->hasConstraints) {
            $widgetConstraintOpt['attr'] = array('style' => 'display:none;');
        }

        $builder->add('widget_constraints', 'collection', $widgetConstraintOpt);

        $builder->addModelTransformer(new JsonMetadataTransformer());
    }
}