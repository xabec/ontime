<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoordisplayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doordisplay', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cabinet_number');
            $table->boolean('status')->default(0);
            $table->integer('doors_id');

            $table->index('doors_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doordisplay');
    }
}
