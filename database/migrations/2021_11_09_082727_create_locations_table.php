<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('town_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->bigInteger('time_hit');
            $table->enum('type',['start_loc','end_loc','mid_loc']);
            $table->boolean('is_rest_loc')->default(false);
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
        Schema::dropIfExists('locations');
    }
}
