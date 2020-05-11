<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Project;
use Chriscreates\Projects\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_be_assigned_a_task()
    {
        $project = factory(Project::class)->create();

        $this->assertEquals($project->tasks->count(), 0);

        $task = factory(Task::class)->create();

        $project->assignTask($task);

        $this->assertEquals($project->tasks->count(), 1);

        $this->assertTrue($project->tasks->first()->is($task));
    }

    /** @test */
    public function a_project_can_have_a_task_removed()
    {
        $project = factory(Project::class)->create();

        $task = factory(Task::class)->create();

        $project->assignTask($task);

        $this->assertEquals($project->tasks->count(), 1);

        $this->assertTrue($project->tasks->first()->is($task));

        $project->removeTask($task);

        $this->assertEquals($project->tasks->count(), 0);
    }

    /** @test */
    public function a_project_can_clarify_whether_it_has_a_task()
    {
        $project = factory(Project::class)->create();

        $task = factory(Task::class)->create();

        $this->assertFalse($project->hasTask($task));

        $project->assignTask($task);

        $this->assertEquals($project->tasks->count(), 1);

        $this->assertTrue($project->tasks->first()->is($task));
    }
}
