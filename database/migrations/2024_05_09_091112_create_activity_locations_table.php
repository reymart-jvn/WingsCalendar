<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->foreign('activity_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('activities');

            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('locations');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('activity_locations');
    }
};
