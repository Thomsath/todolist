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

	public function findAll() {
		return $this->taskRepo->findAll();
	}

	public function findOneById($id) {
		return $this->taskRepo->findBy(
			['id' => $id]
		);
	}

}
	