<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_a_task()
    {
        $this->withoutExceptionHandling();
        $this->signIn()
            ->postJson(route('task-index'), $attributes = factory(Task::class)->raw())
            ->assertStatus(201);

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /** @test */
    public function unauthenticated_user_cant_create_a_task()
    {
        $attributes = factory(Task::class)->raw();

        $this->postJson(route('task-index'), $attributes)
            ->assertStatus(401);
    }
}
