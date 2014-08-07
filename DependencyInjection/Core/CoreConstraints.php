<?php
namespace Chromedia\WidgetFormBuilderBundle\DependencyInjection\Core;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotBlankValidator;
class CoreConstraints
{
    private static $core = array();

    static public function all()
    {
        $test = new NotBlankValidator();

        return self::$core;
    }

    static public function _init()
    {
        self::$core = array(
        	'not_blank' => array(
        	    'name' => 'Not Blank',
        	    'class' => 'Symfony\Component\Validator\Constraints\NotBlank'
        	),
            'email' => array(
                'name' => 'Email',
                'class' => 'Symfony\Component\Validator\Constraints\Email'
            ),
            'regex' => array(
                'name' => 'Regex',
                'class' => 'Symfony\Component\Validator\Constraints\Regex'
            )
        );
    }
}

CoreConstraints::_init();