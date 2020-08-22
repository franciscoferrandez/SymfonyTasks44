<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TaskType;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/backend")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="tasks")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        //$tasks = $task_repo->findAll();
        $tasks = $task_repo->findBy([],['id' => 'DESC']);


        /*
        $user_repo = $this->getDoctrine()->getRepository(User::class);
        $users = $user_repo->findAll();
        foreach ($users as $user) {
            echo "<H1>{$user->getName()} {$user->getSurname()}</H1>";
            foreach ($user->getTasks() as $task) {
                echo "<H2>{$task->getTitle()}</H2>";
            }
        }
        */

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/tasks/mine", name="tasks_mine")
     */
    public function myTasks(UserInterface $user)
    {
        $tasks = $user->getTasks();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/task/view/{id}", name="task")
     */
    public function task(Task $task)
    {
        if (!$task) {
            return $this->redirectToRoute("tasks");
        }

        return $this->render('task/detail.html.twig', array(
            'task' => $task
        ));
    }

    /**
     * @Route("/task/create", name="task_create")
     */
    public function create(Request $request, UserInterface $user)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task->setCreatedAt(new \DateTime());
            $task->setUser($user);

            dump($task);

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl("task", ['id' => $task->getId()])
            );
        }

        return $this->render('task/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/task/edit/{id}", name="task_edit")
     */
    public function edit(Request $request, UserInterface $user, Task $task)
    {
        if ($user && $user->getId() != $task->getUser()->getId()) {
            return $this->redirectToRoute("tasks");
        }

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$task->setCreatedAt(new \DateTime());
            //$task->setUser($user);

            dump($task);

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl("task", ['id' => $task->getId()])
            );
        }

        return $this->render('task/create.html.twig', array(
            'form' => $form->createView(),
            'edit' => true
        ));
    }

    /**
     * @Route("/task/delete/{id}", name="task_delete")
     */
    public function delete (Task $task, UserInterface $user) {
        if (!$task || !$user || ($user->getId() != $task->getUser()->getId())) {
            return $this->redirectToRoute("tasks");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute("tasks");

    }
}
