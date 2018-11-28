<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Loader\UserLoader;
use AppBundle\Loader\UserManager;
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
        if($user->getName() === null || $userloader->isUserAlreadyExists($user->getName()) !== [] ) {
            $errors = "Nom invalide : vide ou déjà prit, désolé !";
            return $this->render('user/users.html.twig', [
                'users' => $users,
                'errors' => $errors,
                'form' => $form->createView(),
            ]);
        }
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($user);
      $entityManager->flush();

      return $this->redirectToRoute('users');
    }

    return $this->render('user/users.html.twig', [
      'users' => $users,
      'form' => $form->createView(),
    ]);
  }


    /**
     * @Route ("/deleteUser/{id}", name="deleteUser")
     */

    public function deleteUser($id, Request $request, UserManager $userManager) {

        $user =$userManager->deleteUserById($id);

        return $this->redirectToRoute('users');
    }

    /**
     * @Route ("/editUser/{id}", name="editUser")
     */

    public function updateUser($id, Request $request, UserLoader $userLoader)
    {
        $user = $userLoader->findOneById($id);
        $userName = $user[0]->getName();

        $form = $this->createFormBuilder($user[0])
            ->add('name', TextType::class, array('data' => $userName))
            ->add('save', SubmitType::class, array('label' => 'Edit User'))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $userManager = $this->getDoctrine()->getManager();
            $userManager->persist($user);
            $userManager->flush();

            return $this->redirectToRoute('users');

        }

        return $this->render('user/editUser.html.twig', [
            'id' => $id,
            'form' => $form->createView(),
        ]);
    }
}