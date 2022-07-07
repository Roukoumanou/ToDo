<?php
namespace App\Service\Interface;

use App\Entity\Task;
use App\Entity\User;

interface TaskInterface
{
    public function taskList(User $user): array;

    public function taskCreate(Task $task, User $user): void;

    public function taskEdit(Task $task): Task;

    public function toggleTaskAction(Task $task): Task;

    public function tasksDone(User $user): array;

    public function taskDelete(Task $task): void;
}
