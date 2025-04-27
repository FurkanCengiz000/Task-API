<?php

namespace App\Services;

use App\DTOs\TaskData;
use App\Repositories\TaskRepository;
use Illuminate\Support\Str;

class TaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected TaskRepository $repository){}

    public function storeTask(TaskData $data)
    {
        return $this->repository->storeTask($data);
    }

    public function updateTask($code, TaskData $data)
    {
        return $this->repository->updateTask($code, $data);
    }

}
