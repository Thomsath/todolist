<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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



}
