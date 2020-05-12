<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Project;
use Chriscreates\Projects\Seeds\ProjectsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_seeder_is_able_to_create_the_full_environment()
    {
        $this->seed(ProjectsSeeder::class);

        $project = Project::with('status', 'tasks')->first();

        $this->assertTrue($project->completed());
    }
}
