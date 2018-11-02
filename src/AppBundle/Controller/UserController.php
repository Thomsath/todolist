<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Loader\UserLoader;

class UserController extends Controller
{
  /**
   * @Route("/users/", name="users")
   */

  public function indexAction(Request $request, UserLoader $userloader)
  {

    $users = $userloader->findAllUsers();

    $user = new User();
    $form = $this->createForm(UserType::class, $user)->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($user);
      $entityManager->flush();

      return $this->redirectToRoute('users');
    }

    return $this->render('task/users.html.twig', [
      'users' => $users,
      'form' => $form->createView(),
    ]);
  }
}