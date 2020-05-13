<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Project;
use Chriscreates\Projects\Models\Status;
use Chriscreates\Projects\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_has_a_title()
    {
        $project = factory(Project::class)->create(['title' => 'Title']);

        $this->assertEquals($project->title, 'Title');
    }

    /** @test */
    public function a_project_has_a_description()
    {
        $project = factory(Project::class)
        ->create(['description' => 'This is a description']);

        $this->assertEquals($project->description, 'This is a description');
    }

    /** @test */
    public function a_project_has_notes()
    {
        $project = factory(Project::class)
        ->create(['notes' => 'These are some notes']);

        $this->assertEquals($project->notes, 'These are some notes');
    }

    /** @test */
    public function a_project_has_togglable_visiblitity()
    {
        $project = factory(Project::class)
        ->create(['visible' => true]);

        $this->assertSame($project->visible, true);
    }

    /** @test */
    public function a_project_has_a_started_at_date()
    {
        $project = factory(Project::class)
        ->create(['started_at' => now()]);

        $this->assertEquals(
            $project->started_at->format('Y-m-d'),
            now()->format('Y-m-d')
        );
    }

    /** @test */
    public function a_project_has_a_delivered_at_date()
    {
        $project = factory(Project::class)
        ->create(['delivered_at' => now()]);

        $this->assertEquals(
            $project->delivered_at->format('Y-m-d'),
            now()->format('Y-m-d')
        );
    }

    /** @test */
    public function a_project_has_a_expected_at_date()
    {
        $project = factory(Project::class)
        ->create(['expected_at' => now()]);

        $this->assertEquals(
            $project->expected_at->format('Y-m-d'),
            now()->format('Y-m-d')
        );
    }

    /** @test */
    public function a_project_has_an_author()
    {
        $project = factory(Project::class)->create(['author_id' => null]);

        $user = factory(User::class)->create();

        $this->assertNull($project->author);

        $project->author()->associate($user);

        $this->assertInstanceOf(User::class, $project->author);
    }

    /** @test */
    public function a_project_has_an_owner()
    {
        $project = factory(Project::class)->create(['owner_id' => null]);

        $user = factory(User::class)->create();

        $this->assertNull($project->owner);

        $project->owner()->associate($user);

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function a_project_can_have_a_status()
    {
        $project = factory(Project::class)->create(['status_id' => null]);

        $status = factory(Status::class)->create();

        $this->assertNull($project->status);

        $project->status()->associate($status);

        $this->assertInstanceOf(Status::class, $project->status);
    }

    /** @test */
    public function a_project_has_comments()
    {
        $project = factory(Project::class)->create();

        $this->assertCount(0, $project->comments);

        $comment = $project->comments()->create(['body' => 'This is a comment']);

        $project->refresh();

        $this->assertCount(1, $project->comments);

        $this->assertTrue($project->comments->first()->is($comment));
    }
}
