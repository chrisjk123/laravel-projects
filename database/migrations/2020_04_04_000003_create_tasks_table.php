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

            $table->foreignId('user_id')->nullable()
            ->references(user_model()->getKeyName())
            ->on(user_model()->getTable());

            $table->foreignId('status_id')->nullable()
            ->references('id')
            ->on('statuses');

            $table->foreignId('priority_id')->nullable()
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

        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
            ->references(user_model()->getKeyName())
            ->on(user_model()->getTable());

            $table->integer('recordable_id');
            $table->string('recordable_type');

            $table->time('time_spent', 0);
            $table->timestamp('time_from')->nullable();
            $table->timestamp('time_to')->nullable();

            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');

        Schema::dropIfExists('tasks');
    }
}
