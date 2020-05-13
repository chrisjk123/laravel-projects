<?php

namespace Chriscreates\Projects\Commands;

use Chriscreates\Projects\Models\Task;
use Illuminate\Console\Command;

class CreateTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:create-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Artisan Command to create a new task.';

    /**
     * Task model.
     *
     * @var object
     */
    private $task;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        parent::__construct();

        $this->task = $task;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $details = $this->getDetails();

        $task = $this->task->create($details);

        $this->display($task);
    }

    /**
     * Ask for task details.
     *
     * @return array
     */
    private function getDetails() : array
    {
        return [
            'title' => $this->ask('Title'),
            'description' => $this->ask('Description'),
            'notes' => $this->ask('Notes'),
            'complete' => $this->ask('Complete'),
        ];
    }

    /**
     * Display created task.
     *
     * @param array $task
     * @return void
     */
    private function display(Task $task) : void
    {
        $headers = ['Title', 'Description', 'Notes', 'Complete'];

        $fields = [
            'title' => $task->title,
            'description' => $task->description,
            'notes' => $task->notes,
            'complete' => $task->complete,
        ];

        $this->info('Task created!');
        $this->table($headers, [$fields]);
    }
}
