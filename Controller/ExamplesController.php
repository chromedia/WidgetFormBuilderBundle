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

        return $this->render('ChromediaWidgetFormBuilderBundle:Examples:index.html.twig', array(
        	'form' => $form->createView()
        ));
    }
}