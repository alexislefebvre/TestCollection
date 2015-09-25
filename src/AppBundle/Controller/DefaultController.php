<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    
    /**
     * @Route("/form", name="form")
     */
    public function formAction(Request $request)
    {
        $object = new \ArrayObject();
        $object->name = '';
        
        $form = $this->createFormBuilder($object)
            ->add('name', 'text')
            ->add('submit', 'submit')
            ->getForm();
            
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            return new Response('<!DOCTYPE html>
                <html><head><title>-</title></head><body><p>
                Data submitted: '.$object->name.
                '</p></body></html>');
        }
        
        // replace this example code with whatever you need
        return $this->render('default/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
