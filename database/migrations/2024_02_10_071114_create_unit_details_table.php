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
        Schema::create('unit_details', function (Blueprint $table) {
            $table->string('unit_name')->unique(); // Set unit_name as unique key
            $table->integer('project_id');
            $table->integer('phase_id');
            $table->integer('type_id');
            $table->integer('building_id');
            $table->timestamps();

            // Foreign key constraints (assuming corresponding tables exist)
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('phase_id')->references('id')->on('phases');
            $table->foreign('type_id')->references('id')->on('unit_types');
            $table->foreign('building_id')->references('id')->on('buildings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_details');
    }
};
