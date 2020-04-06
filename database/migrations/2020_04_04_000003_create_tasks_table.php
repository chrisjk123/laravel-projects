<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->foreign('status_id')
            ->references('id')
            ->on('statuses');

            $table->bigInteger('priority_id')->unsigned()->nullable();
            $table->foreign('priority_id')
            ->references('id')
            ->on('priorities');

            $table->string('title');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            // TODO:
            // cost
            // budget

            // time allocated

            $table->timestamp('started_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('expected_at')->nullable();
            $table->timestamps();
        });

        // TODO:
        // table - task_time
        // task_id
        // user_id
        // time_spent
        // timestamps
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}