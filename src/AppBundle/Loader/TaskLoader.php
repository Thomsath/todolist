<?php

namespace AppBundle\Loader;

use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskLoader {

	private $taskRepo;
	/**
	 * TaskLoader constructor
	 */
	public function __construct(EntityManagerInterface $entityManager) {
		$this->taskRepo = $entityManager->getRepository(Task::class);
	}

    public function findAllTasks($user = false) {
        return $user ? $this->taskRepo->findBy(array(), ['user' => 'DESC']) : $this->taskRepo->findAll();
    }

	public function findOneById($id) {
		return $this->taskRepo->findBy(
			['id' => $id]
		);
	}

	public function findTasksByStatus($status) {
        return $this->taskRepo->findBy(
            ['done' => $status]
        );
	}
	
	public function findTasksByUser($id) {
        return $this->taskRepo->findBy(
            ['user' => $id]
        );
    }

}
	