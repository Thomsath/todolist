<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Loader\UserLoader;

class UserController extends Controller
{
  /**
   * @Route("/users/", name="users")
   */

  public function indexAction(Request $request, UserLoader $userloader) {

    $users = $userloader->findAllUsers();

    return $this->render('task/users.html.twig', [
      'users' => $users
    ]);
  }
}