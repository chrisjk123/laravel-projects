<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Project;

class ProjectHasDueDateTest extends TestCase
{
    /** @test */
    public function it_is_due_in_days()
    {
        $project = Project::create([
            'title' => 'Title',
            'started_at' => now()->subMonths(4),
            'expected_at' => now()->addMonth(1),
        ]);

        $this->assertEquals(
            $project->dueIn('days'),
            now()->subMonths(4)->diffInDays(now()->addMonth(1))
        );
    }

    /** @test */
    public function it_is_due_in_months()
    {
        $project = Project::create([
            'title' => 'Title',
            'started_at' => now()->subMonths(4),
            'expected_at' => now()->addMonth(1),
        ]);

        $this->assertEquals(
            $project->dueIn('months'),
            now()->subMonths(4)->diffInMonths(now()->addMonth(1))
        );
    }

    /** @test */
    public function it_is_due_in_years()
    {
        $project = Project::create([
            'title' => 'Title',
            'started_at' => now()->subMonths(12),
            'expected_at' => now()->addMonth(1),
        ]);

        $this->assertEquals(
            $project->dueIn('years'),
            now()->subMonths(12)->diffInYears(now()->addMonth(1))
        );
    }
}
