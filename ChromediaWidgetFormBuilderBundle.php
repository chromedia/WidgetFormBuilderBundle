<?php

namespace Chromedia\WidgetFormBuilderBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chromedia\WidgetFormBuilderBundle\DependencyInjection\Compiler\FormTemplateCompilerPass;

class ChromediaWidgetFormBuilderBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
    	parent::build($container);

    	$container->addCompilerPass(new FormTemplateCompilerPass());
    }
}
