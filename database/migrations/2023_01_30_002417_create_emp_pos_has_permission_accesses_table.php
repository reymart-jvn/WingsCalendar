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
        Schema::create('emp_pos_has_permission_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_has_position_id')->nullable();
            $table->foreign('employee_has_position_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('employee_has_positions');

            $table->unsignedBigInteger('permission_has_access_id')->nullable();
            $table->foreign('permission_has_access_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('permission_has_accesses');
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
        Schema::dropIfExists('emp_pos_has_permission_accesses');
    }
};
