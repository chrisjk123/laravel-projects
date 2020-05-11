<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectHasVisibilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_is_visible()
    {
        $project = factory(Project::class)->create(['visible' => true]);

        $this->assertTrue($project->isVisible());

        $this->assertTrue($project->visible);
    }

    /** @test */
    public function it_is_not_visible()
    {
        $project = factory(Project::class)->create(['visible' => false]);

        $this->assertFalse($project->isVisible());

        $this->assertFalse($project->visible);
    }

    /** @test */
    public function it_has_been_made_visible()
    {
        $project = factory(Project::class)->create(['visible' => 0]);

        $this->assertFalse($project->isVisible());

        $project->update(['visible' => true]);

        $this->assertTrue($project->isVisible());
    }

    /** @test */
    public function it_has_been_made_not_visible()
    {
        $project = factory(Project::class)->create(['visible' => true]);

        $this->assertTrue($project->isVisible());

        $project->update(['visible' => false]);

        $this->assertFalse($project->isVisible());
    }
}
