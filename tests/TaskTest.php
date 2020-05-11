<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Priority;
use Chriscreates\Projects\Models\Status;
use Chriscreates\Projects\Models\Task;
use Chriscreates\Projects\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_title()
    {
        $task = factory(Task::class)->create(['title' => 'Title']);

        $this->assertEquals($task->title, 'Title');
    }

    /** @test */
    public function it_has_a_description()
    {
        $task = factory(Task::class)
        ->create(['description' => 'This is a description']);

        $this->assertEquals($task->description, 'This is a description');
    }

    /** @test */
    public function it_has_a_notes()
    {
        $task = factory(Task::class)
        ->create(['notes' => 'These are some notes']);

        $this->assertEquals($task->notes, 'These are some notes');
    }

    /** @test */
    public function it_has_a_started_at_date()
    {
        $task = factory(Task::class)
        ->create(['started_at' => now()]);

        $this->assertEquals(
            $task->started_at->toDateTimeString(),
            now()->toDateTimeString()
        );
    }

    /** @test */
    public function it_has_a_delivered_at_date()
    {
        $task = factory(Task::class)
        ->create(['delivered_at' => now()]);

        $this->assertEquals(
            $task->delivered_at->toDateTimeString(),
            now()->toDateTimeString()
        );
    }

    /** @test */
    public function it_has_a_expected_at_date()
    {
        $task = factory(Task::class)
        ->create(['expected_at' => now()]);

        $this->assertEquals(
            $task->expected_at->toDateTimeString(),
            now()->toDateTimeString()
        );
    }

    /** @test */
    public function it_has_can_be_associated_to_a_user()
    {
        $task = factory(Task::class)->create(['user_id' => null]);

        $user = factory(User::class)->create();

        $this->assertNull($task->creator);

        $task->creator()->associate($user);

        $this->assertInstanceOf(User::class, $task->creator);
    }

    /** @test */
    public function it_can_have_a_status()
    {
        $task = factory(Task::class)->create(['status_id' => null]);

        $status = factory(Status::class)->create();

        $this->assertNull($task->status);

        $task->status()->associate($status);

        $this->assertInstanceOf(Status::class, $task->status);
    }

    /** @test */
    public function it_can_have_a_priority()
    {
        $task = factory(Task::class)->create(['priority_id' => null]);

        $priority = factory(Priority::class)->create();

        $this->assertNull($task->priority);

        $task->priority()->associate($priority);

        $this->assertInstanceOf(Priority::class, $task->priority);
    }
}
