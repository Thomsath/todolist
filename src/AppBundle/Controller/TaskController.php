<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Loader\TaskManager;
use AppBundle\Loader\UserLoader;
use AppBundle\Loader\TaskLoader;


class TaskController extends Controller
{
  /**
   * @Route("/", name="homepage")
   */

  public function indexAction(Request $request, TaskLoader $taskLoader) {

      if($request->request->get('selectValue')) {
         // $request->request->get('selectValue') == '1' ? $todo = 0 : $todo = 1;

          if($request->request->get('selectValue') == '1') {
              $todo = 0;
          } elseif($request->request->get('selectValue') == '2') {
              $todo = 1;
          } else {
              $todo = 3;
          }
          if($todo === 0 || $todo === 1) {
              $tasksFiltered = $taskLoader->findTasksByStatus($todo);
          } else {
              $tasksFiltered = $taskLoader->findAllTasks();
          }
          foreach($tasksFiltered as $task) {

              $taskArr[$task->getId()]['title'] =  $task->getTitle();
              $taskArr[$task->getId()]['content'] =  $task->getContent();
              $taskArr[$task->getId()]['priority'] =  $task->getPriority();
              $taskArr[$task->getId()]['done'] =  $task->getDone();
              $taskArr[$task->getId()]['user'] =  $task->getUser()->getName();
          }
          if($request->request->get('selectValue')) {
              $arrData = [
                  'task' => $taskArr,
              ];
              return new JsonResponse($arrData);
          }
      }
      $tasks = $taskLoader->findAllTasks();

      $task = new Task();
      $form = $this->createFormBuilder($task, array('attr' => array('class' => 'formSortTasks')))
          ->add('done', ChoiceType::class, array(
              'choices' => array(
                'Les tâches à faire' => 1,
                'Les tâches réalisées' => 2,
                'Toutes les tâches' => 3,
              ),
              'attr' => array(
                  'class' => 'SortStatus'
              ),
              'label' => 'Trier par statut'
          ))
          ->add('save', SubmitType::class, array('label' => 'Trier'))
          ->getForm();

      $form->handleRequest($request);

      return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
            'form' => $form->createView()
        ]);
  }

    /**
     * @Route ("/{sortDigit}", name="sortTaskByUser", requirements={"sortDigit"="\d+"})
     */
    public function sortTask($sortDigit, Request $request, TaskLoader $taskLoader) {
        $tasks = $taskLoader->findAllTasks(true);
//        $sortDigit === 1 ? $tasks = $taskManager->findAllTasks(true): ;
        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

  /**
   * @Route ("/deleteTask/{id}", name="deleteTask")
   */

  public function deleteTask($id, Request $request, TaskManager $taskManager) {

    $tasks =$taskManager->deleteTaskById($id);

    return $this->redirectToRoute('homepage');
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

      $user = new User();
     // $form = $this->createForm(FormType::class, [$selectUsers, $user])->handleRequest($request);

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
        if($task->getUser() === null) {

            $errors = "Une tâche doit avoir un utilisateur associé";
            return $this->render('task/newTask.html.twig', [
                'errors' => $errors,
                'form' => $form->createView(),
            ]);
        }
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

    /**
     * @Route ("/editTask/{id}", name="editTask")
     */

    public function updateTask($id, Request $request, TaskLoader $taskloader)
    {
        $task = $taskloader->findOneById($id);
        $taskName = $task[0]->getTitle();
        $taskContent = $task[0]->getContent();
        $taskDone = $task[0]->getDone();
        $taskPriority = $task[0]->getPriority();

        $taskDone ? $arrTaskDone = array('checked' => 'none') : $arrTaskDone =  array();
        $taskPriority ? $arrTaskPriority = array('Prioritaire' => true, 'Non prioritaire' => false,) : $arrTaskPriority = array('Non prioritaire' => false, 'Prioritaire' => true);

        $form = $this->createFormBuilder($task[0])
            ->add('content', TextType::class, array('data' => $taskContent))
            ->add('Title', TextType::class, array('data' => $taskName))
            ->add('done', CheckboxType::class, array(
                'label'    => 'Faite',
                'required' => false,
                'attr' => $arrTaskDone,
            ))
            ->add('priority', ChoiceType::class, array(
                'choices' => $arrTaskPriority,
            ))
            ->add('save', SubmitType::class, array('label' => 'Edit Task'))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            $TaskManager = $this->getDoctrine()->getManager();
            $TaskManager->persist($task);
            $TaskManager->flush();

            return $this->redirectToRoute('homepage');

        }

        return $this->render('task/editTask.html.twig', [
            'id' => $id,
            'form' => $form->createView(),
        ]);
    }
}