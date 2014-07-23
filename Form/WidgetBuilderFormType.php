<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Chromedia\WidgetFormBuilderBundle\Form\Transformer\JsonMetadataTransformer;
class WidgetBuilderFormType extends AbstractType
{
    const NAME = 'chromedia_widget_builder_form_type';

    public function getName()
    {
        return self::NAME;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // will either be a core_widge or a custom_widget listed in core_widgets or custom_widgets configuration
        $builder->add('widget_id', 'chromedia_available_widget_choice');

        // this will contain the possible values for widgets that has choices like choice, checkbox, radio
        // TODO: implement this
        $builder->add('widget_choices', 'collection', array(
            'type'      => 'chromedia_widget_choice',
            'allow_add' => true
        ));

        $builder->add('widget_attribute', 'collection', array(
        	'type' => 'chromedia_widget_attribute',
            'allow_add' => true
        ));

        $builder->add('widget_constraints', 'collection', array(
            'type' => 'chromedia_widget_constraint',
            'allow_add' => true
        ));

        $builder->addModelTransformer(new JsonMetadataTransformer());
    }
}