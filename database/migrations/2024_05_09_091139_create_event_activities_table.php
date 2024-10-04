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
        Schema::create('event_activities', function (Blueprint $table) {
            $table->id();
            //new add
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('company_profiles');
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('events');

            $table->unsignedBigInteger('activity_location_id')->nullable();
            $table->foreign('activity_location_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('activity_locations');
            $table->string('date_time')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('event_activities');
    }
};
