<?php

namespace App\Repositories;

use App\DTOs\TaskData;
use App\Models\Task;

class TaskRepository
{
    public function storeTask(TaskData $data)
    {
        return Task::create($data->toArray());
    }
}
