<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class CompletionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_complete_a_scheduled_task()
    {
        $task = factory(Task::class)->create([
            'schedule' => 1 << Carbon::now()->dayOfWeek
        ]);

        $this->assertTrue($task->scheduledToday());
        $this->assertFalse($task->completedToday());

        $this->signIn()
            ->postJson(route('completion-store'), ['task_id' => $task->id])
            ->assertStatus(201);

        $this->assertTrue($task->completedToday());
    }

    /** @test */
    public function unscheduled_task_cannot_be_completed()
    {
        $task = factory(Task::class)->create();

        $this->assertFalse($task->scheduledToday());
        $this->assertFalse($task->completedToday());

        $this->signIn()
            ->postJson(route('completion-store'), ['task_id' => $task->id])
            ->assertStatus(400);

        $this->assertFalse($task->completedToday());
    }

    /** @test */
    public function unauthenticated_user_cant_complete_a_task()
    {
        $task = factory(Task::class)->create();

        $this->postJson(route('completion-store'), ['task_id' => $task->id])
            ->assertStatus(401);
    }
}
