<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Project;

class ProjectHasVisibilityTest extends TestCase
{
    /** @test */
    public function it_is_visible()
    {
        $project = Project::create([
            'title' => 'string2',
            'visible' => true,
        ]);

        $this->assertTrue($project->isVisible());

        $this->assertTrue($project->visible);
    }

    /** @test */
    public function it_is_not_visible()
    {
        $project = Project::create([
            'title' => 'string2',
            'visible' => false,
        ]);

        $this->assertFalse($project->isVisible());

        $this->assertFalse($project->visible);
    }

    /** @test */
    public function it_has_been_made_visible()
    {
        $project = Project::create([
            'title' => 'string2',
            'visible' => false,
        ]);

        $this->assertFalse($project->isVisible());

        $project->update(['visible' => true]);

        $this->assertTrue($project->isVisible());
    }

    /** @test */
    public function it_has_been_made_not_visible()
    {
        $project = Project::create([
            'title' => 'string2',
            'visible' => true,
        ]);

        $this->assertTrue($project->isVisible());

        $project->update(['visible' => false]);

        $this->assertFalse($project->isVisible());
    }
}
