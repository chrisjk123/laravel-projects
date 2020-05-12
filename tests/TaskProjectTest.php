<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Project;
use Chriscreates\Projects\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_task_can_be_assigned_to_a_project()
    {
        $project = factory(Project::class)->create();

        $task = factory(Task::class)->create();

        $this->assertFalse($project->hasTask($task));

        $task->assignToProject($project);

        $project->refresh();

        $this->assertEquals($project->tasks->count(), 1);

        $this->assertTrue($project->tasks->first()->is($task));
    }
}
