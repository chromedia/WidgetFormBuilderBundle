<?php
namespace Chromedia\WidgetFormBuilderBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
class JsonMetadataTransformer implements DataTransformerInterface
{
    /**
     * Transform JSON string to array
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\DataTransformerInterface::transform()
     */
    public function transform($value)
    {
        $schema = \json_decode($value, true);

        return $schema;
    }

    public function reverseTransform($value)
    {
        return json_encode($value);
    }
}