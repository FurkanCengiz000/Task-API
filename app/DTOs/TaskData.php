<?php

namespace App\DTOs;

use App\Http\Requests\TaskRequest;

class TaskData
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $status = 'pending',
    ){}

    public static function fromRequest(TaskRequest $request): self
    {
        return new self(
            title: $request->input('title'),
            description: $request->input('description'),
            status: $request->input("status")
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status
        ];
    }

}
