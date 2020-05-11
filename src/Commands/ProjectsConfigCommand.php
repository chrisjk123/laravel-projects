<?php

namespace Chriscreates\Projects\Commands;

use Illuminate\Console\Command;

class ProjectsConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Artisan Command to publish the projects configuration file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ( ! is_dir(config_path())) {
            $this->error('Config path does not exist.');
        }

        if (projects_config_published()) {
            if ( ! $this->confirm('Config already exists, do you wish to replace it?')) {
                return;
            }
        }

        $this->line('Copying projects config file.');

        // Copy from file to file and replacing if exists
        copy(projects_base_path('/config/projects.php'), config_path('projects.php'));

        $this->info('Pasted projects config file.');
    }
}
