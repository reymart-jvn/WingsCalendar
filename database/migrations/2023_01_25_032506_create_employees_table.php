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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('users');

            $table->unsignedBigInteger('person_has_company_department_id');
            $table->foreign('person_has_company_department_id')
                ->nullable()
                ->constrained()
                ->references('id')->on('person_has_company_departments');
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
        Schema::dropIfExists('employees');
    }
};
