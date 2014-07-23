<?php
namespace Chromedia\WidgetFormBuilderBundle\DependencyInjection\Core;

class CoreConstraints
{
    private static $core = array();

    static public function all()
    {
        return self::$core;
    }

    static public function _init()
    {
        self::$core = array(
        	'not_blank' => array(
        	    'class' => 'Symfony\Component\Validator\Constraints\NotBlank'
        	),
            'email' => array(
                'class' => 'Symfony\Component\Validator\Constraints\Email'
            )
        );
    }
}

CoreConstraints::_init();