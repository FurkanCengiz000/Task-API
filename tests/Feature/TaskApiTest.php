<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class TaskApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_create_task_successfully()
    {
        // Create Test Data
        $payload = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'pending'
        ];

        // Request the API endpoint
        $response = $this->postJson('/api/tasks', $payload);

        // Check the response status code
        $response->assertStatus(201);

        // Check the json data to make sure json data format is correct
        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'title',
                'description',
                'status',
                'created_at',
                'updated_at'
            ],
        ]);

        // Check the database column to make sure the related column is exist
        $this->assertDatabaseHas('tasks', [
            'title' => $payload['title'],
            'description' => $payload['description'],
            'status' => $payload['status']
        ]);
    }

    public function test_validate_data_should_fail_when_required_fields_are_missing()
    {
        $payload = [
            'title' => '',
            'description' => '',
            'status' => ''
        ];

        $response = $this->postJson('/api/tasks', $payload);

        // Validation hatası bekliyoruz
        $response->assertStatus(422);

        // Hatalı alanları kontrol ediyoruz
        $response->assertJsonValidationErrors([
            'title',
            'description',
        ]);
    }

    public function test_status_field_should_fail_when_invalid_value_is_given()
    {
        // Create Test Data
        $payload = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'asd'
        ];

        $response = $this->postJson('/api/tasks', $payload);

        // Validation hatası bekliyoruz
        $response->assertStatus(422);

        // Hatalı alanları kontrol ediyoruz
        $response->assertJsonValidationErrors([
            'status',
        ]);
    }

    public function test_task_can_be_updated_successfully()
    {
        // Find To Task
        $task = Task::factory()->create();

        // Create Test Data
        $payload = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'pending'
        ];

       // response tasks put method
       $response = $this->putJson("api/tasks/{$task->code}", $payload);

       // Check the response status code
       $response->assertStatus(200);

       // Check the data
       $response->assertJsonFragment([
        'title' => $payload['title'],
        'description' => $payload['description'],
        'status' => $payload['status'],
    ]);

       // Check the json data to make sure json data format is correct
        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'title',
                'description',
                'status',
                'created_at',
                'updated_at'
            ],
        ]);

        // Check the database column to make sure the related column is exist
        $this->assertDatabaseHas('tasks', [
            'code' => $task->code,
            'title' => $payload['title'],
            'description' => $payload['description'],
            'status' => $payload['status']
        ]);
    }

    public function test_task_update_should_fail_with_missing_required_fields()
    {
        $payload = [
            'title' => '',
            'description' => '',
            'status' => ''
        ];

        $task = Task::factory()->create();

        $response = $this->putJson("api/tasks/{$task->code}", $payload);


        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'title',
            'description',
        ]);

    }

    public function test_task_update_should_fail_with_invalid_status()
    {
        $payload = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'asd'
        ];

        $task = Task::factory()->create();

        $response = $this->putJson("api/tasks/{$task->code}", $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'status'
        ]);
    }

    public function test_task_update_should_return_404_if_task_not_found()
    {
        $payload = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'pending'
        ];

        $random_uuid = (string) Str::uuid();

        // response tasks put method
       $response = $this->putJson("api/tasks/{$random_uuid}", $payload);

       // Check the response status code
       $response->assertStatus(404);

    }

    public function test_task_can_be_deleted_successfully()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("api/tasks/{$task->code}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tasks', [
            'code' => $task->code
        ]);

    }

    public function test_task_delete_should_return_404_if_task_not_found()
    {
        $random_uuid = (string) Str::uuid();

        $response = $this->deleteJson("api/tasks/{$random_uuid}");

        $response->assertStatus(404);

    }

}
