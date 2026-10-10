<?php

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

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

    public function new(): string
    {
        return view('tasks/new', [
            'title'      => 'New Task',
            'activePage' => 'new-task',
            'errors'     => session('errors') ?? [],
        ]);
    }

    public function create(): RedirectResponse
    {
        $validation = service('validation');
        $validation->setRules($this->taskRules());

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url('tasks/new'))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $taskModel = new TaskModel();
        $taskModel->insert($this->taskData(true));

        return redirect()->to(site_url('tasks'))
            ->with('success', 'Task created successfully.');
    }

    public function edit(int $id): string
    {
        $task = (new TaskModel())->findActive($id);

        if ($task === null) {
            throw PageNotFoundException::forPageNotFound('Active task not found.');
        }

        return view('tasks/edit', [
            'title'      => 'Edit Task',
            'activePage' => 'tasks',
            'task'       => $task,
            'errors'     => session('errors') ?? [],
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $taskModel = new TaskModel();

        if ($taskModel->findActive($id) === null) {
            throw PageNotFoundException::forPageNotFound('Active task not found.');
        }

        $validation = service('validation');
        $validation->setRules($this->taskRules());

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url("tasks/{$id}/edit"))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $taskModel->update($id, $this->taskData(false));

        return redirect()->to(site_url('tasks'))
            ->with('success', 'Task updated successfully.');
    }

    public function archive(int $id): RedirectResponse
    {
        $taskModel = new TaskModel();

        if ($taskModel->findActive($id) === null) {
            throw PageNotFoundException::forPageNotFound('Active task not found.');
        }

        $taskModel->update($id, ['is_archived' => 1]);

        return redirect()->to(site_url('tasks'))
            ->with('success', 'Task archived successfully.');
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function taskRules(): array
    {
        return [
            'title' => [
                'label' => 'Task title',
                'rules' => 'required|max_length[150]',
            ],
            'task_date' => [
                'label' => 'Task date',
                'rules' => 'required|valid_date[Y-m-d]',
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required|in_list[pending,in_progress,completed]',
            ],
        ];
    }

    /**
     * @return array<string, int|string>
     */
    private function taskData(bool $includeCreationFields): array
    {
        $data = [
            'title'     => trim((string) $this->request->getPost('title')),
            'status'    => (string) $this->request->getPost('status'),
            'task_date' => (string) $this->request->getPost('task_date'),
        ];

        if ($includeCreationFields) {
            $data['is_archived'] = 0;
            $data['created_at']  = date('Y-m-d H:i:s');
        }

        return $data;
    }
}
