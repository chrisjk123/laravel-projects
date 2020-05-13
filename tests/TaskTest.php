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
    public function a_task_has_a_title()
    {
        $task = factory(Task::class)->create(['title' => 'Title']);

        $this->assertEquals($task->title, 'Title');
    }

    /** @test */
    public function a_task_has_a_description()
    {
        $task = factory(Task::class)
        ->create(['description' => 'This is a description']);

        $this->assertEquals($task->description, 'This is a description');
    }

    /** @test */
    public function a_task_has_notes()
    {
        $task = factory(Task::class)
        ->create(['notes' => 'These are some notes']);

        $this->assertEquals($task->notes, 'These are some notes');
    }

    /** @test */
    public function a_task_can_be_associated_to_a_creator()
    {
        $task = factory(Task::class)->create(['user_id' => null]);

        $user = factory(User::class)->create();

        $this->assertNull($task->creator);

        $task->creator()->associate($user);

        $this->assertInstanceOf(User::class, $task->creator);
    }

    /** @test */
    public function a_task_can_have_a_priority()
    {
        $task = factory(Task::class)->create(['priority_id' => null]);

        $priority = factory(Priority::class)->create();

        $this->assertNull($task->priority);

        $task->priority()->associate($priority);

        $this->assertInstanceOf(Priority::class, $task->priority);
    }

    /** @test */
    public function a_task_can_be_created_from_the_command_line()
    {
        $this->artisan('projects:create-task')
        ->expectsQuestion('Title', 'Test Title')
        ->expectsQuestion('Description', 'Test Description')
        ->expectsQuestion('Notes', 'Some Notes')
        ->expectsQuestion('Complete', true)
        ->assertExitCode(0);

        $this->assertEquals(1, Task::count());
    }

    /** @test */
    public function a_task_has_comments()
    {
        $task = factory(Task::class)->create();

        $this->assertCount(0, $task->comments);

        $comment = $task->comments()->create(['body' => 'This is a comment']);

        $task->refresh();

        $this->assertCount(1, $task->comments);

        $this->assertTrue($task->comments->first()->is($comment));
    }
}
