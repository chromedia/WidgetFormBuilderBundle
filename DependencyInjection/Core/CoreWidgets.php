<?php
namespace Chromedia\WidgetFormBuilderBundle\DependencyInjection\Core;

final class CoreWidgets
{
    private static $all = array(
        'text' => array(
            'with_choices' => false
        ),

        'textarea' => array(
            'with_choices' => false
        ),
        'choice' => array(
            'with_choices' => true
        ),
        'checkbox' => array(
            'with_choices' => true
        ),
        'radio' => array(
            'with_choices' => true
        ),
    );

    static public function all()
    {
        return self::$all;
    }

    static public function _init()
    {
        foreach (self::$all as $widgetId => &$widgetProperties) {
            $widgetProperties['name'] = \ucfirst($widgetId);
        }
    }
}

CoreWidgets::_init();