<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class ConstraintChoiceFieldType extends AbstractType
{
    private $defaultChoices;

    private $constraintOptions;

    public function getName()
    {
        return 'chromedia_constraint_choice';
    }

    public function setChoices($choices)
    {
        $this->defaultChoices = $choices;
    }

    public function setConstraintOptions($v)
    {
        $this->constraintOptions = $v;
    }

    public function getParent()
    {
        return 'choice';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->defaultChoices,
            'constraint_options' => $this->constraintOptions
        ));
    }
}