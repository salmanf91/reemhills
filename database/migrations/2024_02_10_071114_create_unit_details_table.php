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
            // Set unit_name as unique key
            $table->id();
            $table->string('unit_name')->unique(); 
            $table->string('project_id')->nullable();
            $table->string('phase_id')->nullable();
            $table->string('type_id')->nullable();
            $table->string('building_id')->nullable();
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
        Schema::dropIfExists('unit_details');
    }
};
