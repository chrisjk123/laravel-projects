<?php

namespace Chriscreates\Projects\Seeds;

use Chriscreates\Projects\Models\Priority;
use Chriscreates\Projects\Models\Project;
use Chriscreates\Projects\Models\Status;
use Chriscreates\Projects\Models\Task;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    private $statuses = [
        'Done',
        'In Progress',
        'Not Started',
        'Cancalled',
    ];

    private $priorities = [
        'Low',
        'Minor',
        'Moderate',
        'Significant',
        'Required',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = collect($this->statuses)
        ->map(function ($status) {
            return factory(Status::class)->create(['name' => $status]);
        });

        $priorities = collect($this->priorities)
        ->map(function ($priority) {
            return factory(Priority::class)->create(['name' => $priority]);
        });

        $project = factory(Project::class)->create([
            'started_at' => now()->subMonth(),
            'delivered_at' => now()->subDays(2),
            'expected_at' => now(),
            'status_id' => $statuses->random()->id,
        ]);

        $tasks = factory(Task::class, 4)
        ->create(['priority_id' => $priorities->random()->id])
        ->each
        ->assignToProject($project);
    }
}
