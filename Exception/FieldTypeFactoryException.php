<?php
namespace Chromedia\WidgetFormBuilderBundle\Exception;

class FieldTypeFactoryException extends \Exception
{
    static public function widgetIdUnavailable($widgetId)
    {
        return new self("Widget id: {$widgetId} is not available.");
    }
}