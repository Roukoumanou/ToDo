<?php
namespace App\Service\DomainCode;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Service\Interface\TaskInterface;
use Doctrine\ORM\EntityManagerInterface;

class TasksService implements TaskInterface
{
    private EntityManagerInterface $em;

    private TaskRepository $taskRepository;

    public function __construct(EntityManagerInterface $em, TaskRepository $taskRepository)
    {
        $this->em = $em;
        $this->taskRepository = $taskRepository;
    }

    /**
     * Permet de récupérer la liste des tâches à faire appartenant à un utilisateur
     *
     * @param User $user
     * @return array
     */
    public function taskList(User $user): array
    {
        $task = $this->taskRepository->getTasks($user);

        return (array) $task;
    }

    /**
     * Ajoute une tâche dans la BDD
     *
     * @param Task $task
     * @param User $user
     * @return void
     */
    public function taskCreate(Task $task, User $user): void
    {
        $task->setUser($user);

            $this->em->persist($task);
            $this->em->flush();
    }

    /**
     * Permet de modifier une tâche appartenant à une utilisateur
     *
     * @param Task $task
     * @return Task
     */
    public function taskEdit(Task $task): Task
    {
        $this->em->flush();

        return $task;
    }

    /**
     * Permet de d'ouvrir ou de fermer une tâche appartenant à une utilisateur
     *
     * @param Task $task
     * @return Task
     */
    public function toggleTaskAction(Task $task): Task
    {
        $task->toggle(!$task->isDone());
        $this->em->flush();

        return $task;
    }

    /**
     * Permet de lister les tâches déja fait d'un utilisateur
     *
     * @param User $user
     * @return array
     */
    public function tasksDone(User $user): array
    {
        $tasks = $this->taskRepository->getTasksDone($user);

        return (array) $tasks;
    }

    /**
     * Permet de supprimer une tâche d'un utilisateur
     *
     * @param Task $task
     * @return void
     */
    public function taskDelete(Task $task): void
    {
        $this->em->remove($task);
        $this->em->flush();
    }
}
