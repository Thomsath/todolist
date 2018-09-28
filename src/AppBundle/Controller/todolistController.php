<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Model\Task;
use AppBundle\Model\User;

class todolistController extends Controller
{
    /**
     * @Route("/todolist", name="todolist")
     */
    public function todolistAction(Request $request)
    {
        $this->get('session')->set('tasks', [new Task('Tache 1', new User(1, 'simon'), 'Titre tache 1'), new Task('Tache 2', new User(2, 'thomas'), 'Titre tache 2'), new Task('Tache 3', new User(3, 'gaetan'), 'Titre tache 3')]);
        //dump($this->get('session')->get('tasks'));

        return $this->render('default/todolist.html.twig', [
            'sessions' => $this->get('session')->get('tasks')
        ]);
    }
    

    /**
     * @Route("/todolist/edit/{id}", name="edit")
     */

    public function editTask($id, Request $request) {
        // Décalag entre content tache et son nom > La tache 0 a pour contenu "Tache 1" ...
       $taskContent = $this->get('session')->get('tasks')[$id]->getContent(); 
       $taskUserName = $this->get('session')->get('tasks')[$id]->getTaskUser()->getName();
       $taskTitle = $this->get('session')->get('tasks')[$id]->getTitle();
       $taskUserId = $id;

       $currentTask = $this->get('session')->get('tasks')[$id];
       
        //$task = new Task('Tache 1', 'user 1');
            $form = $this->createFormBuilder($currentTask)
            ->add('content', TextType::class)
            ->add('Title', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Edit Task'))
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
           
            $task = $form->getData();
            $task->setContent($task->getContent());
            $task->setTitle($task->getTitle());

        }
        return $this->render('default/todolist_edit.html.twig', [ 
            'id' => $id,
            'taskContent' => $taskContent,
            'form' => $form->createView(),
            'taskUserName' => $taskUserName,
            'taskUserId' => $taskUserId,
            'taskTitle' => $taskTitle
        ]);
    }

}
