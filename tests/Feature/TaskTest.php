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
        $this->signIn()
            ->postJson(route('task-store'), $attributes = factory(Task::class)->raw())
            ->assertStatus(201);

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /** @test */
    public function unauthenticated_user_cant_create_a_task()
    {
        $attributes = factory(Task::class)->raw();

        $this->postJson(route('task-store'), $attributes)
            ->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_list_all_tasks()
    {
        factory(Task::class, $count = 2)->create();

        $response = $this->signIn()
            ->getJson(route('task-index'))
            ->json();

        $this->assertCount($count, $response['not_completed']);
    }

    /** @test */
    public function unauthenticated_user_cant_list_all_tasks()
    {
        $this->getJson(route('task-index'))
            ->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_filter_tasks_that_should_be_completed_today()
    {
        factory(Task::class, 2)->create();
        factory(Task::class)
            ->states('today')
            ->create();

        $response = $this->signIn()
            ->getJson(route('task-index', 'today'))
            ->json();

        $this->assertCount(1, $response['not_completed']);
    }
}
