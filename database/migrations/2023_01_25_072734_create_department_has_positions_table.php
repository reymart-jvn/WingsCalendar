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
        Schema::create('department_has_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('departments');

            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('positions');
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
        Schema::dropIfExists('department_has_positions');
    }
};
