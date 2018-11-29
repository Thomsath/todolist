<?php

namespace App\Loader;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserLoader {

  private $userRepo;
  /**
   * UserLoader constructor
   */
  public function __construct(EntityManagerInterface $entityManager) {
    $this->userRepo = $entityManager->getRepository(User::class);
  }

  public function findAllUsers() {
    return $this->userRepo->findAll();
  }

  public function findOneById($id) {
    return $this->userRepo->findBy(
      ['id' => $id]
    );
  }

  public function isUserAlreadyExists($username) {
      return $this->userRepo->findBy(
          ['name' => $username]
      );
  }

}
