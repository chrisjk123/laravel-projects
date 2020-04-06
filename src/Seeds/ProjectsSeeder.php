<?php

namespace Chriscreates\Projects\Seeds;

use Chriscreates\Projects\Models\Priority;
use Chriscreates\Projects\Models\Project;
use Chriscreates\Projects\Models\Status;
use Chriscreates\Projects\Models\Task;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    private $priorities = [
        'Low',
        'Minor',
        'Moderate',
        'Significant',
        'Required',
    ];

    private $statuses = [
        'Done',
        'In Progress',
        'Not Started',
        'Cancalled',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project1 = Project::firstOrCreate(
            ['title' => 'Project One'],
            [
                'started_at' => now()->subMonth(),
                'delivered_at' => now(),
                'expected_at' => now(),
            ]
        );

        $project2 = Project::firstOrCreate(
            ['title' => 'Project Two'],
            [
                'started_at' => now(),
                'delivered_at' => now()->addMonth(1),
                'expected_at' => now()->addMonth(2),
            ]
        );

        for ($x = 0; $x <= 10; $x++) {
            Task::firstOrCreate(
                ['title' => 'Test title'.$x],
                [
                    'started_at' => now()->subMonth(),
                    'delivered_at' => now(),
                    'expected_at' => now(),
                ]
            );
        }

        foreach ($this->priorities as $priority) {
            Priority::firstOrCreate(['name' => $priority]);
        }

        foreach ($this->statuses as $status) {
            Status::firstOrCreate(['name' => $status]);
        }
    }
}
