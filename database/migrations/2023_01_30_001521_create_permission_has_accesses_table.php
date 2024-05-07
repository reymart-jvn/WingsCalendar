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
        Schema::create('permission_has_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->foreign('permission_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('permissions');

            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('company_profiles');

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

            $table->unsignedBigInteger('access_id')->nullable();
            $table->foreign('access_id')
            ->nullable()
            ->constrained()
            ->references('id')->on('accesses');
            
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
        Schema::dropIfExists('permission_has_accesses');
    }
};
