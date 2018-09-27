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
        $this->get('session')->set('tasks', [new Task('Tache 1', new User(1, 'simon')), new Task('Tache 2', new User(2, 'thomas')), new Task('Tache 3', new User(3, 'gaetan'))]);
        //dump($this->get('session')->get('tasks'));

        return $this->render('default/todolist.html.twig', [
            'sessions' => $this->get('session')->get('tasks')
        ]);
    }
    

    /**
     * @Route("/todolist/edit/{id}", name="edit")
     */

    public function editTask($id, Request $request) {
       $taskContent = $this->get('session')->get('tasks')[$id]->getContent(); 
        $task = new Task('Tache 1', 'user 1');
               $form = $this->createFormBuilder($task)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Edit Task'))
            ->getForm();

        return $this->render('default/todolist_edit.html.twig', [ 
            'id' => $id,
            'tasks' => $task,
            'taskContent' => $taskContent,
            'form' => $form->createView()
        ]);
    }

}
