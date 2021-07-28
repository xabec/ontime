<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->datetime('date_created');
            $table->datetime('date_finished')->nullable();
            $table->datetime('date_confirmed')->nullable();
            $table->text('visit_information')->nullable();
            $table->datetime('visit_date');
            $table->text('comments')->nullable();
            $table->text('recommendations')->nullable();
            $table->text('conclusion')->nullable();
            $table->integer('status')->default(0);
            $table->json('unregistereduserdata')->nullable();
            $table->integer('unlock_id');
            $table->integer('doors_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('doctor_id');

            $table->index('doors_id');
            $table->index('user_id');
            $table->index('doctor_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
