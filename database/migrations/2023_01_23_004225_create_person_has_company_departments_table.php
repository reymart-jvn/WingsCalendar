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
        Schema::create('person_has_company_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('people');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('company_profiles');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('departments');
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
        Schema::dropIfExists('person_has_company_departments');
    }
};
