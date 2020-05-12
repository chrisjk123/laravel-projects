<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Priority;
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
    public function it_has_can_be_associated_to_a_user()
    {
        $task = factory(Task::class)->create(['user_id' => null]);

        $user = factory(User::class)->create();

        $this->assertNull($task->creator);

        $task->creator()->associate($user);

        $this->assertInstanceOf(User::class, $task->creator);
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
