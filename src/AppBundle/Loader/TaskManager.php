<?php

namespace AppBundle\Loader;

use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskManager {

	private $taskRepo;
	/**
	 * TaskLoader constructor
	 */

	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager) {
		$this->taskRepo = $entityManager->getRepository(Task::class);
		$this->entityManager = $entityManager;
	}

	public function deleteTaskById($id) {
        $task = $this->taskRepo->findOneBy(array('id' => $id));

        if ($task != null){
            $this->entityManager->remove($task);
            $this->entityManager->flush();
        }
	}
}
	