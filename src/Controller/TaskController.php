<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Service\Interface\TaskInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/users")
 */
class TaskController extends AbstractController
{
    private TaskInterface $iTask;

    public function __construct(TaskInterface $iTask)
    {
        $this->iTask = $iTask;
    }

    /**
     * @Route("/tasks", name="task_list", methods={"GET"})
     *
     * @return Response
     */
    public function listAction(): Response
    {
        $tasks = $this->iTask->taskList($this->getUser());

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
            'status' => ""
        ]); 
    }

    /**
     * @Route("/tasks/create", name="task_create", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->iTask->taskCreate($task, $this->getUser());

            $this->addFlash('success', 'La tâche a été bien ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER') and user === task.getUser()")
     *
     * @param Task $task
     * @param Request $request
     * @return Response
     */
    public function editAction(Task $task, Request $request): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $this->iTask->taskEdit($task);

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle", methods={"GET"})
     * @Security("is_granted('ROLE_USER') and user === task.getUser()")
     *
     * @param Task $task
     * @return Response
     */
    public function toggleTaskAction(Task $task): Response
    {
        $task = $this->iTask->toggleTaskAction($task);

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks-done", name="tasks_done", methods={"GET"})
     *
     * @return Response
     */
    public function tasksDone(): Response
    {
        $tasksDone = $this->iTask->tasksDone($this->getUser());

        return $this->render('task/list.html.twig', [
            'tasks' => $tasksDone,
            'status' => "faites"
        ]);
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     * @Security("is_granted('ROLE_USER') and user === task.getUser()")
     *
     * @param Task $task
     * @return Response
     */
    public function deleteTaskAction(Task $task): Response
    {
        $this->iTask->taskDelete($task);

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
