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
        Schema::create('people_person_in_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('company_profiles');
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('people');
            $table->unsignedBigInteger('personincharge_id')->nullable();
            $table->foreign('personincharge_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('person_in_charges');
            $table->string('fullname')->nullable();
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
        Schema::dropIfExists('people_person_in_charges');
    }
};
