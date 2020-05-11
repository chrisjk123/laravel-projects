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
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('user_id')->nullable()
            ->references(user_model()->getKeyName())
            ->on(user_model()->getTable());

            $table->foreignId('status_id')->nullable()
            ->references('id')
            ->on('statuses');

            $table->string('title');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->integer('visible')->default(1)->nullable();
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

        Schema::create('project_users', function (Blueprint $table) {
            $table->increments('id');

            $table->foreignId('project_id')
            ->references('id')
            ->on('projects');

            $table->foreignId('user_id')
            ->references(user_model()->getKeyName())
            ->on(user_model()->getTable());

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
