<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
        $builder->add('widget_choices', 'collection');
    }
}