<?php

namespace App\Http\Controllers;

use App\DTOs\TaskData;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service) {}

    public function store(TaskRequest $request)
    {
        try {
            // get validated data then put in data transfer object(dto)
            $dto = TaskData::fromRequest($request);

            // Send Dto to TaskService's storeTask() method to store Task Process
            $task = $this->service->storeTask($dto);

            // return response status code
            return (new TaskResource($task))->response()->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json(['message', $e->getMessage()], 422);
        }
    }
}
