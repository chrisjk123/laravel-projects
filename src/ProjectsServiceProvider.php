<?php

namespace Chriscreates\Projects;

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
        $this->handleEvents();

        $this->handleMigrations();

        $this->handlePublishing();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->handleConfig();
    }

    /**
     * Register the events and listeners.
     *
     * @return void
     * @throws BindingResolutionException
     */
    private function handleEvents()
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
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function handlePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/factories/' => database_path('factories'),
            ], 'project-factories');

            $this->publishes([
                __DIR__.'/../config/projects.php' => config_path('projects.php'),
            ], 'projects-config');
        }
    }

    /**
     * @return void
     */
    private function handleConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/projects.php',
            'config'
        );
    }
}
