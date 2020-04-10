<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\ProjectsServiceProvider;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    // use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            ProjectsServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        Schema::dropAllTables();

        $this->loadMigrationsFrom(projects_base_path('/database/test_migrations'));
        $this->loadMigrationsFrom(projects_base_path('/database/migrations'));
    }
}
