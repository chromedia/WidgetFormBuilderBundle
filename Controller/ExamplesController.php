<?php
namespace Chromedia\WidgetFormBuilderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Chromedia\WidgetFormBuilderBundle\Form\WidgetBuilderFormType;
class ExamplesController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new WidgetBuilderFormType());

        if ($request->isMethod('POST')) {
        	$form->submit($request);
        	var_dump(json_encode($form->getData()));
        	// var_dump(json_decode($form->getData())->widget_constraints);
        	// exit;;

        }

        return $this->render('ChromediaWidgetFormBuilderBundle:Examples:index.html.twig', array(
        	'form' => $form->createView()
        ));
    }
}