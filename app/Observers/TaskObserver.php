<?php

namespace App\Observers;

use App\Models\Task;
use Illuminate\Support\Str;

class TaskObserver
{
    public function creating(Task $task): void
    {
        if(empty($task->code))
        {
            $task->code = (string) Str::uuid();
        }
    }
}
