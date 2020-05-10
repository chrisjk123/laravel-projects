<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Project;
use Chriscreates\Projects\Models\Status;
use Chriscreates\Projects\Models\User;
use Illuminate\Support\Facades\Hash;

class ProjectTest extends TestCase
{
    /** @test */
    public function it_has_a_title()
    {
        $project = Project::create(['title' => 'Title']);

        $this->assertEquals($project->title, 'Title');
    }

    /** @test */
    public function it_has_a_description()
    {
        $project = Project::create([
            'title' => 'Title',
            'description' => 'This is a description',
        ]);

        $this->assertEquals($project->description, 'This is a description');
    }

    /** @test */
    public function it_has_a_notes()
    {
        $project = Project::create([
            'title' => 'Title',
            'notes' => 'These are some notes',
        ]);

        $this->assertEquals($project->notes, 'These are some notes');
    }

    /** @test */
    public function it_has_togglable_visiblitity()
    {
        $project = Project::create([
            'title' => 'Title',
            'visible' => true,
        ]);

        $this->assertSame($project->visible, true);
    }

    /** @test */
    public function it_has_a_started_at_date()
    {
        $project = Project::create([
            'title' => 'Title',
            'started_at' => now(),
        ]);

        $this->assertEquals(
            $project->started_at->toDateTimeString(),
            now()->toDateTimeString()
        );
    }

    /** @test */
    public function it_has_a_delivered_at_date()
    {
        $project = Project::create([
            'title' => 'Title',
            'delivered_at' => now(),
        ]);

        $this->assertEquals(
            $project->delivered_at->toDateTimeString(),
            now()->toDateTimeString()
        );
    }

    /** @test */
    public function it_has_a_expected_at_date()
    {
        $project = Project::create([
            'title' => 'Title',
            'expected_at' => now(),
        ]);

        $this->assertEquals(
            $project->expected_at->toDateTimeString(),
            now()->toDateTimeString()
        );
    }

    /** @test */
    public function it_has_can_be_associated_to_a_user()
    {
        $project = Project::create(['title' => 'Title']);

        $user = User::create([
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
        ]);

        $this->assertNull($project->owner);

        $project->owner()->associate($user);

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function it_has_can_be_associated_to_a_status()
    {
        $project = Project::create(['title' => 'Title']);

        $status = Status::create(['name' => 'Test']);

        $this->assertNull($project->status);

        $project->status()->associate($status);

        $this->assertInstanceOf(Status::class, $project->status);
    }
}
