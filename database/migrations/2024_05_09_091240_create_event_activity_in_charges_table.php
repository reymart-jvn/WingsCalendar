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
        Schema::create('event_activity_in_charges', function (Blueprint $table) {
            $table->id();
            //add
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('company_profiles');
            $table->unsignedBigInteger('personincharge_id')->nullable();
            $table->foreign('personincharge_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('person_in_charges');
            $table->unsignedBigInteger('event_activity_id')->nullable();
            $table->foreign('event_activity_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('event_activities');
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
        Schema::dropIfExists('event_activity_in_charges');
    }
};
