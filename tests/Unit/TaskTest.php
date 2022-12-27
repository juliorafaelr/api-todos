<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test if index endpoint works.
     *
     * @return void
     */
    public function testGetTasks()
    {
        $user = User::factory()->create();

        $token = $user->createToken('Test');

        $response = $this->withHeaders([
            'Accept' => 'application/vnd.api+json',
            'Authorization' => "Bearer $token->plainTextToken"
        ])->get('/api/v1/tasks');

        $response->assertStatus(200);
    }

    public function testGetTask()
    {
        $user = User::factory()->create();

        $token = $user->createToken('Test');

        $task = Task::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/vnd.api+json',
            'Authorization' => "Bearer $token->plainTextToken"
        ])->get('/api/v1/tasks/' . $task->uuid);

        $response->assertStatus(200);
    }

    public function testCreateTask()
    {
        $user = User::factory()->create();

        $token = $user->createToken('Test');

        $data = [
            'data' => [
                'type' => 'tasks',
                'attributes' => [
                    'text' => 'test task',
                    'day' => 'Sunday the 21st',
                    'done' => false
                ]
            ]
        ];

        $response = $this->postJson(
            '/api/v1/tasks',
            $data,
            [
                'Accept' => 'application/vnd.api+json',
                'Content-Type' => 'application/vnd.api+json',
                'Authorization' => "Bearer $token->plainTextToken"
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJsonFragment(
                [
                    "text" => "test task",
                    'day' => 'Sunday the 21st',
                    "done" => false
                ]
            );
    }

    public function testUpdateTask()
    {
        $user = User::factory()->create();

        $token = $user->createToken('Test');

        $task = Task::factory()->create();

        $data = [
            'data' => [
                'id' => $task->uuid,
                'type' => 'tasks',

                'attributes' => [
                    "text" => "updated task",
                    "done" => true
                ]
            ]
        ];

        $response = $this->patchJson(
            '/api/v1/tasks/' . $task->uuid,
            $data,
            [
                'Accept' => 'application/vnd.api+json',
                'Content-Type' => 'application/vnd.api+json',
                'Authorization' => "Bearer $token->plainTextToken"
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    "text" => "updated task",
                    "done" => true
                ]
            );
    }

    public function testDeleteTask()
    {
        $user = User::factory()->create();

        $token = $user->createToken('Test');

        $task = Task::factory()->create();

        $response = $this->deleteJson(
            '/api/v1/tasks/' . $task->uuid,
            [],
            [
                'Accept' => 'application/vnd.api+json',
                'Authorization' => "Bearer $token->plainTextToken"
            ]
        );

        $response->assertStatus(204);
    }

    public function testNotfoundTask()
    {
        $user = User::factory()->create();

        $token = $user->createToken('Test');

        $response = $this->withHeaders([
            'Accept' => 'application/vnd.api+json',
            'Authorization' => "Bearer $token->plainTextToken"
        ])->get('/api/v1/tasks/' . md5('test'));

        $response->assertStatus(404);
    }

    public function testUnauthorizedRequest()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/vnd.api+json',
        ])->get('/api/v1/tasks');

        $response->assertStatus(401);
    }
}
