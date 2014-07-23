<?php
namespace Chromedia\WidgetFormBuilderBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConstraintOptionsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $constraintsParameter = '_cwfb.widget_constraints';

        if ($container->hasParameter($constraintsParameter)) {
            $constraints = $container->getParameter($constraintsParameter);
            foreach ($constraints as $key => $constraintsData) {

            }
        }
    }
}