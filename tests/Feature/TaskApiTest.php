<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
