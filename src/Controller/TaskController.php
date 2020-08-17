<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="tasks")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        /*
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findAll();
        */

        $user_repo = $this->getDoctrine()->getRepository(User::class);
        $users = $user_repo->findAll();
        foreach ($users as $user) {
            echo "<H1>{$user->getName()} {$user->getSurname()}</H1>";
            foreach ($user->getTasks() as $task) {
                echo "<H2>{$task->getTitle()}</H2>";
            }
        }


        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
