<?php

namespace Tests\Unit;

use App\Task;
use App\Weekday;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->task = factory(Task::class)->create();
    }

    /** @test */
    public function it_knows_if_it_should_be_completed_today()
    {
        $weekday = resolve(Weekday::class);

        $this->assertFalse($this->task->scheduledToday());

        $this->task->schedule = $weekday->today();

        $this->assertTrue($this->task->scheduledToday());

        $this->task->schedule = $weekday->today() + $weekday->anotherDay();

        $this->assertTrue($this->task->scheduledToday());
    }

    /** @test */
    public function it_knows_if_it_was_completed_today()
    {
        $this->assertFalse($this->task->completedToday());

        $this->signIn()
            ->task
            ->complete();

        $this->assertTrue($this->task->completedToday());

        $this->task
            ->completions()
            ->first()
            ->forceFill([
                'created_at' => Carbon::now()->subtract(1, 'day')
            ])
            ->save();

        $this->assertFalse($this->task->fresh()->completedToday());
    }
}
