<?php
/**
 * Created by PhpStorm.
 * User: tbe
 * Date: 28/11/2018
 * Time: 14:06
 */

namespace App\Loader;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{

    private $userRepo;
    /**
     * UserManager constructor
     */

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->userRepo = $entityManager->getRepository(User::class);
        $this->entityManager = $entityManager;
    }

    public function deleteUserById($id) {
        $user = $this->userRepo->findOneBy(array('id' => $id));

        if ($user != null){
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
    }
}