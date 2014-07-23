<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Chromedia\WidgetFormBuilderBundle\Form\Transformer\JsonMetadataTransformer;

class WidgetAttributeFieldType extends AbstractType
{
    public function getName()
    {
        return 'chromedia_widget_attribute';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        	'allow_add' => true,
            'prototype' => true,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('key', 'text');
        $builder->add('value', 'text');

        //$builder->addModelTransformer(new JsonMetadataTransformer());
    }
}