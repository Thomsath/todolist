<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Loader\TaskLoader;

class TaskController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */

    public function indexAction(Request $request, TaskLoader $taskloader) {

    	$tasks = $taskloader->findAllTasks();

    	return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }
}