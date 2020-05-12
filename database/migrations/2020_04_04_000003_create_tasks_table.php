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

            $table->foreignId('priority_id')->nullable()
            ->references('id')
            ->on('priorities');

            $table->string('title');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->boolean('complete')->nullable()->default(false);

            // TODO:
            // cost
            // budget

            // time allocated
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
        Schema::dropIfExists('tasks');
    }
}
