<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\TodoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends Controller
{
    /**
     * @Route("/", name="todo_list")
     */
    public function indexAction()
    {
        $todos = $this->mockTodos();
        return $this->render('todo/index.html.twig', ['todos' => $todos]);
    }

    /**
     * @Route("/todos/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
        $todo = []; // new Todo;

        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $dueDate = $form['dueDate']->getData();

            $createTodo = new CreateTodo($name, $category, $description, $priority, $dueDate);

            $this->addFlash('notice', 'Todo Added');

            return $this->redirectToRoute('todo_list');
        }

        return $this->render('todo/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/todos/edit/{id}", name="todo_edit")
     */
    public function editAction($id, Request $request)
    {
        $todo = $this->mockSingleTodo();

        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $dueDate = $form['dueDate']->getData();

            $createTodo = new EditTodo($name, $category, $description, $priority, $dueDate);

            $this->addFlash('notice', 'Todo Updated');

            return $this->redirectToRoute('todo_list');
        }

        return $this->render('todo/edit.html.twig', [
            'todo' => $todo,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/todos/details/{id}", name="todo_details")
     */
    public function detailsAction($id)
    {
        $todo = $this->mockSingleTodo();

        return $this->render('todo/details.html.twig', ['todo' => $todo]);
    }

    /**
     * @Route("/todos/delete/{id}", name="todo_delete")
     */
    public function deleteAction($id)
    {
        $deleteTodo = new DeleteTodo($id);

        $this->addFlash('notice', 'Todo Removed');

        return $this->redirectToRoute('todo_list');
    }

    private function mockTodos()
    {
        $todos = [];

        $now = new \DateTime('now');

        $todo1 = new \stdClass();
        $todo1->id = 1;
        $todo1->name = 'Write symfony demo';
        $todo1->dueDate = $now;


        $todo2 = new \stdClass();
        $todo2->id = 2;
        $todo2->name = 'Write laravel demo';
        $todo2->dueDate = $now;

        $todo3 = new \stdClass();
        $todo3->id = 3;
        $todo3->name = 'Write backend demo';
        $todo3->dueDate = $now;

        $todos[] = $todo1;
        $todos[] = $todo2;
        $todos[] = $todo3;

        return $todos;
    }

    private function mockSingleTodo()
    {
        $now = new \DateTime('now');

        $todo = new \stdClass();
        $todo->id = 1;
        $todo->name = 'Write symfony demo';
        $todo->dueDate = $now;
        $todo->description = 'random test goes here';
        $todo->category = 'work work work';
        $todo->priority = 'Low';

        return $todo;
    }
}

class CreateTodo
{
    private $name;
    private $category;
    private $description;
    private $priority;
    private $dueDate;

    public function __construct($name, $category, $description, $priority, $dueDate)
    {
        $this->name = $name;
        $this->category = $category;
        $this->description = $description;
        $this->priority = $priority;
        $this->dueDate = $dueDate;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }
}

class EditTodo
{
    private $name;
    private $category;
    private $description;
    private $priority;
    private $dueDate;

    public function __construct($name, $category, $description, $priority, $dueDate)
    {
        $this->name = $name;
        $this->category = $category;
        $this->description = $description;
        $this->priority = $priority;
        $this->dueDate = $dueDate;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }
}

class DeleteTodo
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
