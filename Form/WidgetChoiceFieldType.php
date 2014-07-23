<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Chromedia\WidgetFormBuilderBundle\Form\Transformer\JsonMetadataTransformer;

class WidgetChoiceFieldType extends AbstractType
{
    public function getName()
    {
        return 'chromedia_widget_choice';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'allow_add' => true,
            'prototype' => true
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder->add('choice', 'text', array('label' => false));

        //$builder->addModelTransformer(new JsonMetadataTransformer());
    }
}