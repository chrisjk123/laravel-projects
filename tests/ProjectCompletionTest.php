<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Project;
use Chriscreates\Projects\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectCompletionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_is_measurable()
    {
        $project = factory(Project::class)->create();

        $this->assertTrue($project->hasDateTarget());
    }

    /** @test */
    public function a_project_can_be_in_progress()
    {
        $project = factory(Project::class)->create([
            'started_at' => now()->subMonth(),
            'delivered_at' => null,
            'expected_at' => now(),
        ]);

        $this->assertTrue($project->isInProcess());
    }

    /** @test */
    public function a_project_can_be_completed()
    {
        $project = factory(Project::class)->create([
            'delivered_at' => now(),
        ]);

        $this->assertTrue($project->completed());
    }

    /** @test */
    public function a_project_can_be_completed_when_initally_expected()
    {
        $project = factory(Project::class)->create([
            'started_at' => now()->subMonth(),
            'delivered_at' => now(),
            'expected_at' => now(),
        ]);

        $this->assertTrue($project->completedOnSchedule());
    }

    /** @test */
    public function a_project_can_be_completed_ahead_of_schedule()
    {
        $project = factory(Project::class)->create([
            'started_at' => now()->subMonth(),
            'delivered_at' => now()->subWeek(),
            'expected_at' => now(),
        ]);

        $this->assertTrue($project->completedBeforeSchedule());
    }

    /** @test */
    public function a_project_can_be_completed_after_the_inital_deadline()
    {
        $project = factory(Project::class)->create([
            'started_at' => now()->subMonth(),
            'delivered_at' => now()->addWeek(),
            'expected_at' => now(),
        ]);

        $this->assertTrue($project->completedAfterSchedule());
    }

    /** @test */
    public function a_project_can_be_overdue_and_not_yet_delivered()
    {
        $project = factory(Project::class)->create([
            'started_at' => now()->subMonth(),
            'delivered_at' => null,
            'expected_at' => now()->subWeek(),
        ]);

        $this->assertTrue($project->isOverdue());
    }

    /** @test */
    public function a_project_can_be_expected_in_coming_time()
    {
        $project = factory(Project::class)->create([
            'started_at' => now()->subMonth(),
            'delivered_at' => null,
            'expected_at' => now()->addWeek(),
        ]);

        $this->assertTrue($project->notDueYet());
    }

    /** @test */
    public function when_a_project_completes_all_its_tasks_it_is_then_complete()
    {
        $project = factory(Project::class)->create();

        $tasks = factory(Task::class, 4)->create(['complete' => false]);

        $tasks->each->assignToProject($project);

        $this->assertFalse($project->completed());

        $tasks->each->markCompletion(true);

        $this->assertTrue($project->completed());
    }
}
