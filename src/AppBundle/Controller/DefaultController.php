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
         $this->get('session')->set('tasks', [new Task('Tache 0', new User(1, 'simon'), 'Titre tache 0'), new Task('Tache 1', new User(2, 'thomas'), 'Titre tache 1'), new Task('Tache 2', new User(3, 'gaetan'), 'Titre tache 2')]);

         return $this->redirectToRoute('todolist');
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'sessions' => $this->get('session')->get('tasks')
        ]);
    }
}
