<?php

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\RESTful\ResourceController;

class TasksController extends ResourceController
{
    protected $modelName = 'App\Models\TaskModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $task = $this->model->find($id);
        if (!$task) return $this->failNotFound('Tarea no encontrada');
        return $this->respond($task);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if (!isset($data['title']) || empty(trim($data['title']))) {
            return $this->failValidationErrors('El título es obligatorio');
        }

        $id = $this->model->insert([
            'title' => $data['title'],
            'completed' => false
        ]);

        return $this->respondCreated($this->model->find($id));
    }

    public function update($id = null)
    {
        $task = $this->model->find($id);
        if (!$task) return $this->failNotFound('Tarea no encontrada');

        $data = $this->request->getJSON(true);
        $updateData = [];
        if (isset($data['title'])) $updateData['title'] = $data['title'];
        if (isset($data['completed'])) $updateData['completed'] = $data['completed'];

        $this->model->update($id, $updateData);
        return $this->respondUpdated($this->model->find($id));
    }

    public function delete($id = null)
    {
        $task = $this->model->find($id);
        if (!$task) return $this->failNotFound('Tarea no encontrada');

        $this->model->delete($id);
        return $this->respondDeleted(['id' => $id]);
    }
}