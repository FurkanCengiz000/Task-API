<?php

namespace App\Repositories;

use App\DTOs\TaskData;
use App\Models\Task;

class TaskRepository
{
    public function storeTask(TaskData $data): Task
    {
        return Task::create($data->toArray());
    }

    public function updateTask($code, TaskData $data)
    {
        $task = $this->findTaskByCode($code);

        $task->update($data->toArray());

        return $task;

    }

    private function findTaskByCode($code): Task
    {
        return Task::where('code', $code)->firstOrFail();
    }
}
