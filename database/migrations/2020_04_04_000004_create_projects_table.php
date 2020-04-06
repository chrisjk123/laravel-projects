<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user_class = config('projects.user_class');
        $user_model = new $user_class;

        Schema::create('projects', function (Blueprint $table) use ($user_model) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
            ->references($user_model->getKeyName())
            ->on($user_model->getTable());

            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->foreign('status_id')
            ->references('id')
            ->on('statuses');

            $table->string('title');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->integer('visible')->default(1)->nullable();
            $table->integer('type')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('expected_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('projectables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('projectable_id');
            $table->string('projectable_type');
        });

        Schema::create('project_users', function (Blueprint $table) use ($user_model) {
            $table->increments('id');

            $table->bigInteger('project_id')->unsigned();
            $table->foreign('project_id')
            ->references('id')
            ->on('projects');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references($user_model->getKeyName())
            ->on($user_model->getTable());

            $table->string('status')->nullable();
            $table->string('role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_users');

        Schema::dropIfExists('projectables');

        Schema::dropIfExists('projects');
    }
}