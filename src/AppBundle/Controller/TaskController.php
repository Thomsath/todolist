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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;

use AppBundle\Loader\TaskLoader;
use AppBundle\Loader\UserLoader;

class TaskController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */

    public function indexAction(Request $request, TaskLoader $taskloader, UserLoader $userloader) {

    	$tasks = $taskloader->findAllTasks();

        $users = $userloader->findAllUsers();

    	return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route ("/newTask", name="newTask")
     */

    public function addTask(Request $request, UserLoader $userloader) {

    	$task = new Task();

        $users = $userloader->findAllUsers();
        $selectUsers = [];
        
        // ['thomas' => 'thomas']
        foreach($users as $user) {
            $selectUsers[$user->getName()] = $user;
        }
dump($selectUsers);
        $form = $this->createFormBuilder($task)
    			->add('title', TextType::class, array('required' => true,))
    			->add('content', TextType::class, array('required' => true,))
    			->add('priority', CheckboxType::class, array('required' => false,))
    			->add('done', CheckboxType::class, array('required' => false,))
                ->add('user', ChoiceType::class, array(
                    'choices' => $selectUsers,
                ))
                ->add('save', SubmitType::class, array('label' => 'Ajouter la tache'))
    			->getForm();
 		
 		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()) {
            $form->getData();

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