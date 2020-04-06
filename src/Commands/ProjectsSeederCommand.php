<?php

namespace Chriscreates\Projects\Commands;

use Chriscreates\Projects\Seeds\ProjectsSeeder;
use Illuminate\Console\Command;

class ProjectsSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Artisan Command to call the repository seeds.';

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
        if ( ! projects_config_published()) {
            $this->error('Config has not been published.');

            if ( ! $this->confirm('Would you like to publish the config?')) {
                return;
            }

            $this->call('projects:publish');
        }

        $this->line('Starting project seeds.');

        set_time_limit(0);

        do {
            if (projects_config_published()) {
                $this->callSilent('config:cache');
                $this->call(ProjectsSeeder::class);
                $this->callSilent('config:clear');

                break;
            }
        } while (true);

        $this->info('Finished project seeds.');
    }
}
