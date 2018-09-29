<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use AppBundle\Model\Task;
use AppBundle\Model\User;

class todolistController extends Controller
{
    /**
     * @Route("/todolist", name="todolist")
     */
    public function todolistAction(Request $request)
    {
       //this->get('session')->set('tasks', [new Task('Tache 1', new User(1, 'simon'), 'Titre tache 1'), new Task('Tache 2', new User(2, 'thomas'), 'Titre tache 2'), new Task('Tache 3', new User(3, 'gaetan'), 'Titre tache 3')]);


        return $this->render('default/todolist.html.twig', [
            'sessions' => $this->get('session')->get('tasks'),
            'array_keys' => array_keys($this->get('session')->get('tasks'))
        ]);
    }
    

    /**
     * @Route("/todolist/edit/{id}", name="edit")
     */

    public function editTask($id, Request $request) {
        // Décalag entre content tache et son nom > La tache 0 a pour contenu "Tache 1" ...
       $taskContent = $this->get('session')->get('tasks')[$id]->getContent(); 
      // dump($this->get('session')->get('tasks')[$id]->getUser());die;
       $taskUserName = $this->get('session')->get('tasks')[$id]->getUser()->getName();
       $taskTitle = $this->get('session')->get('tasks')[$id]->getTitle();
       $taskUserId = $id;

       $currentTask = $this->get('session')->get('tasks')[$id];
       
        //$task = new Task('Tache 1', 'user 1');
            $form = $this->createFormBuilder($currentTask)
            ->add('Id', IntegerType::class)
            ->add('content', TextType::class)
            ->add('Title', TextType::class)
             ->add('priority', ChoiceType::class, array(
                'choices' => array(
                    'Prioritaire' => 1,
                    'Non prioritaire' => 0,
                ),
                ))
            ->add('save', SubmitType::class, array('label' => 'Edit Task'))
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
           
            $task = $form->getData();

            $task->setId($task->getId());
            $task->setContent($task->getContent());
            $task->setTitle($task->getTitle());
            $task->setPriority($task->getPriority());

            return $this->redirectToRoute('todolist');

        }
        return $this->render('default/todolist_edit.html.twig', [ 
            'id' => $id,
            'taskContent' => $taskContent,
            'form' => $form->createView(),
            'taskUserName' => $taskUserName,
            'taskUserId' => $taskUserId,
            'taskTitle' => $taskTitle,
        ]);
    }

     /**
     * @Route("/todolist/delete/{id}", name="delete")
     */

    public function removeTask($id, Request $request) {

        $sessionArr = $this->get('session')->get('tasks');

        unset($sessionArr[$id]);
       
        $this->get('session')->set('tasks', $sessionArr);
        
        // foreach($sessionArr as $value) {
        //     dump($value);
        // }
        // die;
        return $this->redirectToRoute('todolist');
    }

    /**
     * @Route("/todolist/add", name="add")
     */

    public function addTask(Request $request) {

        $tasktoAdd = new Task(0,0,0,0,0);

        $formAdd = $this->createFormBuilder($tasktoAdd)
        ->add('Id', IntegerType::class)
        ->add('Title', TextType::class)
        ->add('content', TextType::class)
        ->add('user', TextType::class)
        ->add('priority', ChoiceType::class, array(
        'choices' => array(
            'Prioritaire' => 1,
            'Non prioritaire' => 0,
        ),
        ))
        ->add('save', SubmitType::class, array('label' => 'Ajouter'))
        ->getForm();

        $formAdd->handleRequest($request);

        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
           
            $task = $formAdd->getData();

            $task->setId($task->getId());
            $task->setTitle($task->getTitle());
            $task->setContent($task->getContent());
            $userAdd = new User (rand(1, 1200), $task->getUser());
            $task->setUser($userAdd);
           // $this->get('session')->a('tasks', [new Task('Tache 4', new User(1, 'simon'), 'Titre tache 4')]);
            $sessionArr = $this->get('session')->get('tasks');
            
            array_push($sessionArr, $tasktoAdd);

            // On réasigne le tableau modifié dans la session
            $this->get('session')->set('tasks', $sessionArr);
            
            return $this->redirectToRoute('todolist');

        }

        return $this->render('default/todolist_add.html.twig', [ 
            'form' => $formAdd->createView()
        ]);
    }

}
