<?php
namespace Chromedia\WidgetFormBuilderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Chromedia\WidgetFormBuilderBundle\Form\Transformer\WidgetConfigOptionTransformer;

class WidgetConfigOptionFieldType extends AbstractType
{
    private $availableOptions;

    // private $defaultData;

    public function getName()
    {
        return 'chromedia_widget_config_option';
    }

    public function setWidgetConfigOptions($v)
    {
        foreach ($v as $widgetOption) {
            if (is_array($widgetOption)) {
                foreach ($widgetOption as $key => $item) {
                    $this->availableOptions[$key] = $key;
                }
            }
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('config_option', 'choice', array(
            'label'   => 'Option',
            'choices' => $this->availableOptions
        ));

        $builder->add('config_option_value', 'text', array(
            'label' => 'Value'
        ));

         $builder->addModelTransformer(new WidgetConfigOptionTransformer());
    }
}