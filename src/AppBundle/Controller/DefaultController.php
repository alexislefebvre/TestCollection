<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Task;
use AppBundle\Entity\Tag;
use AppBundle\Form\Type\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
            ->add('name', TextType::class)
            ->add('submit', SubmitType::class)
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

    /**
     * @Route("/task", name="task")
     */
    public function newAction(Request $request)
    {
        $task = new Task();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $tag1 = new Tag();
        $tag1->name = 'tag1';
        $task->getTags()->add($tag1);
        $tag2 = new Tag();
        $tag2->name = 'tag2';
        $task->getTags()->add($tag2);
        // end dummy code

        $form = $this->createForm(TaskType::class, $task, array(
            'action' => $this->get('router')->generate('task')
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
        }

        return $this->render('AppBundle:Task:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
