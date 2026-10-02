<?php

namespace App\Controllers;

use App\Models\TaskModel;

class Tasks extends BaseController
{
    public function today(): string
    {
        $taskModel = new TaskModel();
        $today     = date('Y-m-d');

        $data = [
            'title'      => "Today's Tasks",
            'activePage' => 'home',
            'today'      => $today,
            'tasks'      => $taskModel->findForDate($today),
        ];

        return view('home', $data);
    }

    public function index(): string
    {
        $taskModel = new TaskModel();

        $data = [
            'title'      => 'All Tasks',
            'activePage' => 'tasks',
            'tasks'      => $taskModel->findAllOrdered(),
        ];

        return view('tasks/index', $data);
    }
}
