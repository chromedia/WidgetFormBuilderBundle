<?php
namespace Chromedia\WidgetFormBuilderBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
class FormTemplateCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // add form_template to twig's form resources
        $formTemplateParameter = '_cwfb.form_template';
        if ($container->hasParameter($formTemplateParameter)) {
            $template = $container->getParameter($formTemplateParameter);
            $twigResources = $container->getParameter('twig.form.resources');

            // check that our form template has not been loaded yet in form configuration
            if (false !== ($key = array_search('form_div_layout.html.twig', $twigResources))) {
                array_splice($twigResources, ++$key, 0, $template);
            } else {
                array_unshift($twigResources, $template);
            }

            $container->setParameter('twig.form.resources', $twigResources);
        }
    }
}