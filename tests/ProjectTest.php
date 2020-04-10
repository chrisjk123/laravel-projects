<?php

namespace Chriscreates\Projects\Tests;

use Carbon\Carbon;
use Chriscreates\Projects\Models\Project;

class ProjectTest extends TestCase
{
    private $project1;

    public function setUp(): void
    {
        parent::setUp();

        $this->assertCount(0, Project::all());

        $this->project1 = Project::firstOrCreate(
            ['title' => 'string1'],
            [
                'visible' => true,
                'started_at' => now()->subMonth(),
                'delivered_at' => now(),
                'expected_at' => now(),
            ]
        );
    }

    /** @test */
    public function it_can_create_a_project()
    {
        $this->assertInstanceOf(Project::class, $this->project1);

        $this->assertCount(1, Project::all());

        $this->assertSame('string1', $this->project1->title);
    }

    /** @test */
    public function it_has_visibility()
    {
        $project2 = Project::firstOrCreate(
            ['title' => 'string2'],
            [
                'visible' => 0,
            ]
        );

        $project3 = Project::firstOrCreate(
            ['title' => 'string3'],
            [
                'visible' => false,
            ]
        );

        $this->assertTrue($this->project1->isVisible());

        $this->assertTrue($this->project1->visible);

        $this->assertFalse($project2->isVisible());

        $this->assertTrue($project3->isNotVisible());

        $this->assertEquals(
            ['string1', 'string2', 'string3'],
            Project::pluck('title')->toArray()
        );

        $this->assertCount(3, Project::all());
    }

    /** @test */
    public function it_has_a_due_date()
    {
        // Days
        $days = $this->project1->dueIn('days');
        $last_month_days = Carbon::now()->subMonth(1)->daysInMonth;

        $this->assertEquals($days, $last_month_days);
        $this->assertSame($days, $last_month_days);
        $this->assertTrue($days == $last_month_days);

        // Months
        $project2 = Project::firstOrCreate(
            ['title' => 'string2'],
            [
                'started_at' => now()->subMonths(4),
                'expected_at' => now()->addMonth(1),
            ]
        );

        $months = $project2->dueIn('months');
        $this->assertEquals($months, 5);
        $this->assertSame($months, 5);
        $this->assertTrue($months == 5);

        // Years
        $project3 = Project::firstOrCreate(
            ['title' => 'string3'],
            [
                'started_at' => now()->subYear(1),
                'expected_at' => now()->addMonths(2),
            ]
        );

        $years = $project3->dueIn('years');
        $this->assertEquals($years, 1);
        $this->assertSame($years, 1);
        $this->assertTrue($years == 1);

        $this->assertEquals(
            ['string1', 'string2', 'string3'],
            Project::pluck('title')->toArray()
        );

        $this->assertCount(3, Project::all());
    }

    // TODO
    // Has Comments
}
