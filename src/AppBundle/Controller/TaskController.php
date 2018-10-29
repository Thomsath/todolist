<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;

use AppBundle\Loader\TaskLoader;

class TaskController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */

    public function indexAction(Request $request, TaskLoader $taskloader) {

    	$tasks = $taskloader->findAll();

    	return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route ("/newTask", name="newTask")
     */

    public function addTask(Request $request) {

    	$task = new Task();

    	$form = $this->createFormBuilder($task)
    			->add('title', TextType::class)
    			->add('content', TextType::class)
    			->add('priority', CheckboxType::class)
    			->add('done', CheckboxType::class)
    			->add('save', SubmitType::class, array('label' => 'Ajouter la tache'))
    			->getForm();
 		
 		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()) {
			$customUser = new User();

			$customUser->setName('Thomas');
		    // $form->getData() holds the submitted values
		    // but, the original `$task` variable has also been updated
		    $task = $form->getData();
			$task->setUser($customUser);
		    // ... perform some action, such as saving the task to the database
		    // for example, if Task is a Doctrine entity, save it!
		    
		    $TaskManager = $this->getDoctrine()->getManager();
		    $TaskManager->persist($task);
		    $TaskManager->flush();

		    return $this->redirectToRoute('homepage');
		}
			return $this->render('task/newTask.html.twig', array(
					'form' => $form->createView(),
	));
    }
}