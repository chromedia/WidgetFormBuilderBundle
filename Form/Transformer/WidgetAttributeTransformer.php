<?php
namespace Chromedia\WidgetFormBuilderBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;


class WidgetAttributeTransformer implements DataTransformerInterface
{
    const KEY_INDEX = 'key';
    const VALUE_INDEX = 'value';

    /**
     * 
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\DataTransformerInterface::transform()
     */
    public function transform($widgetAttribute)
    {
        if (!empty($widgetAttribute)) {
            return array(
                self::KEY_INDEX   => array_keys($widgetAttribute)[0],
                self::VALUE_INDEX => array_values($widgetAttribute)[0]
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