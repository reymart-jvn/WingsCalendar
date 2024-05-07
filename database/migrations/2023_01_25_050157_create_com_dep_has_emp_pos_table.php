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
        Schema::create('com_dep_has_emp_pos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_has_company_department_id');
            $table->foreign('person_has_company_department_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('person_has_company_departments');
            $table->unsignedBigInteger('employee_has_position_id');
            $table->foreign('employee_has_position_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('employee_has_positions');
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
        Schema::dropIfExists('com_dep_has_emp_pos');
    }
};
