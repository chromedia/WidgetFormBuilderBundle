<?php
namespace Chromedia\WidgetFormBuilderBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;


class WidgetConfigOptionTransformer implements DataTransformerInterface
{
    const KEY_INDEX = 'config_option';
    const VALUE_INDEX = 'config_option_value';

    /**
     * 
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\DataTransformerInterface::transform()
     */
    public function transform($widgetAttribute)
    {
        if (!empty($widgetAttribute)) {
            $arrayKeys = array_keys($widgetAttribute);
            $arrayAttributes = array_values($widgetAttribute);

            return array(
                self::KEY_INDEX   => $arrayKeys[0],
                self::VALUE_INDEX => $arrayAttributes[0]
            );
        } 

        return array(self::KEY_INDEX => '', self::VALUE_INDEX => '');
    }

    /**
     * Transforms parameter to form array('key_value' => 'value_value')
     * 
     * @param array $widgetAttribute Contains array('key' => 'key_value', 'value' => 'value_value')
     */
    public function reverseTransform($widgetAttribute)
    {
        if (!empty($widgetAttribute)) {
            return array($widgetAttribute[self::KEY_INDEX] => $widgetAttribute[self::VALUE_INDEX]);
        } 

        return array();       
    }
}