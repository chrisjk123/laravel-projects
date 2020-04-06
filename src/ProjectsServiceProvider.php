<?php

namespace Chriscreates\Projects;

use Chriscreates\Projects\Commands\ProjectsConfigCommand;
use Chriscreates\Projects\Commands\ProjectsSeederCommand;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class ProjectsServiceProvider extends ServiceProvider
{
    /**
       * All of the event / listener mappings.
       *
       * @var array
       */
    protected $events = [];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->bootEvents();

        $this->handleMigrations();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();

        foreach (glob(__DIR__.'/Helpers/*.php') as $file) {
            require_once($file);
        }
    }

    /**
     * Register the events and listeners.
     *
     * @return void
     * @throws BindingResolutionException
     */
    private function bootEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function handleMigrations()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    /**
     * @return void
     */
    private function registerCommands()
    {
        $this->commands([
            ProjectsConfigCommand::class,
            ProjectsSeederCommand::class,
        ]);
    }
}
