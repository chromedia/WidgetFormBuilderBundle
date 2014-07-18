<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvailableWidgetChoiceFieldType extends AbstractType
{
    private $defaultChoices;

    public function getName()
    {
        return 'chromedia_available_widget_choice';
    }

    public function setChoices($choices)
    {
        $this->defaultChoices = $choices;
    }

    public function getParent()
    {
        return 'choice';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('choices' => $this->defaultChoices));
    }
}