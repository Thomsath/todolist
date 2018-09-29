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

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // Task excepted Task(ID, Content, User, Title, Priority)
         $this->get('session')->set('tasks', [new Task(0, 'Tache 0', new User(0, 'simon'), 'Titre tache 0', 1), new Task(1, 'Tache 1', new User(1, 'thomas'), 'Titre tache 1', 0), new Task(2, 'Tache 2', new User(2, 'gaetan'), 'Titre tache 2', 1)]);

         return $this->redirectToRoute('todolist');
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'sessions' => $this->get('session')->get('tasks')
        ]);
    }
}
