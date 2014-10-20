<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Chromedia\WidgetFormBuilderBundle\Form\Transformer\JsonMetadataTransformer;

class ConstraintPropertyFieldType extends AbstractType
{
    public function getName()
    {
        return 'chromedia_constraint_option';
    }

     public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'prototype' => true,
            'allow_add' => true,
            'required'  => false,
            'empty_data' => '',
            'data' => ''
        ));
    }

    public function getParent()
    {
        return 'text';
    }
}