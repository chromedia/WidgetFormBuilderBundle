<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class WidgetConstraintFieldType extends AbstractType
{
    public function getName()
    {
        return 'chromedia_widget_constraint';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('constraint_id', 'chromedia_constraint_choice', array(
        	'label' => 'Constraint'
        ));

        $builder->add('constraint_options', 'collection', array(
        	'type' => 'chromedia_constraint_option',
            'allow_add' => true,
            'prototype_name' => '__constraint_option_name__',
        ));
    }

}