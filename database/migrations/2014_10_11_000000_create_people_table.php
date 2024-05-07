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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->longText('code')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('affiliation')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('region_id')->nullable();
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('city_mun')->nullable();
            $table->string('barangay')->nullable();
            $table->string('zip_code')->nullable();
            $table->longText('home_address')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('religion')->nullable();
            $table->string('status')->nullable();
            $table->longText('image')->nullable();
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
        Schema::dropIfExists('people');
    }
};
