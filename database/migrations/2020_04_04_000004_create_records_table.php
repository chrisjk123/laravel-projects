<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('user_id')->nullable()
            ->references(user_model()->getKeyName())
            ->on(user_model()->getTable());

            $table->morphs('recordable');

            $table->timestamp('time_from')->nullable();
            $table->timestamp('time_to')->nullable();

            $table->decimal('add_hours', 10, 2)->nullable();
            $table->decimal('deduct_hours', 10, 2)->nullable();
            $table->boolean('deductable')->nullable();

            $table->text('description')->nullable();
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
    }
}
