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
        // send dto and code to TaskReposity's storeTask() method then return
        return $this->repository->storeTask($data);
    }

}
