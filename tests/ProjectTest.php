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
    public function it_has_a_title()
    {
        $project = factory(Project::class)->create(['title' => 'Title']);

        $this->assertEquals($project->title, 'Title');
    }

    /** @test */
    public function it_has_a_description()
    {
        $project = factory(Project::class)
        ->create(['description' => 'This is a description']);

        $this->assertEquals($project->description, 'This is a description');
    }

    /** @test */
    public function it_has_a_notes()
    {
        $project = factory(Project::class)
        ->create(['notes' => 'These are some notes']);

        $this->assertEquals($project->notes, 'These are some notes');
    }

    /** @test */
    public function it_has_togglable_visiblitity()
    {
        $project = factory(Project::class)
        ->create(['visible' => true]);

        $this->assertSame($project->visible, true);
    }

    /** @test */
    public function it_has_a_started_at_date()
    {
        $project = factory(Project::class)
        ->create(['started_at' => now()]);

        $this->assertEquals(
            $project->started_at->toDateTimeString(),
            now()->toDateTimeString()
        );
    }

    /** @test */
    public function it_has_a_delivered_at_date()
    {
        $project = factory(Project::class)
        ->create(['delivered_at' => now()]);

        $this->assertEquals(
            $project->delivered_at->toDateTimeString(),
            now()->toDateTimeString()
        );
    }

    /** @test */
    public function it_has_a_expected_at_date()
    {
        $project = factory(Project::class)
        ->create(['expected_at' => now()]);

        $this->assertEquals(
            $project->expected_at->toDateTimeString(),
            now()->toDateTimeString()
        );
    }

    /** @test */
    public function it_has_can_be_associated_to_a_user()
    {
        $project = factory(Project::class)->create(['user_id' => null]);

        $user = factory(User::class)->create();

        $this->assertNull($project->owner);

        $project->owner()->associate($user);

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function it_can_have_a_status()
    {
        $project = factory(Project::class)->create(['status_id' => null]);

        $status = factory(Status::class)->create();

        $this->assertNull($project->status);

        $project->status()->associate($status);

        $this->assertInstanceOf(Status::class, $project->status);
    }
}
