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
        $builder->add('widget_id', 'chromedia_available_widget_choice');
    }
}