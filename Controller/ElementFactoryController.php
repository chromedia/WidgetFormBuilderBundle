<?php
namespace Chromedia\WidgetFormBuilderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class ElementFactoryController extends Controller
{
    public function availableWidgetsJavascriptAction()
    {
        //
        $widgetsData = $this->container->getParameter('_cwfb.available_widgets');

        // build a form that contains the prototypes of the widgets
        $formBuilder = $this->createFormBuilder(null, array('csrf_protection' => false));

        foreach ($widgetsData as $widgetId => $data) {
            $formBuilder->add($widgetId, $widgetId);

        }
        $form = $formBuilder->getForm();

        $response = $this->render('ChromediaWidgetFormBuilderBundle:ElementFactory:availableWidgets.js.twig', array(
        	'formPrototype' => $form->createView()
        ));

        $response->headers->set('content-type', 'application/javascript');
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;
    }
}