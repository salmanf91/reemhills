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
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // Use Laravel's auto-incrementing primary key
            $table->string('name')->unique(); // Add unique constraint on name
            $table->timestamps(); // Include created_at and updated_at columns
        });

        Schema::create('phases', function (Blueprint $table) {
            $table->id(); // Use Laravel's auto-incrementing primary key
            $table->string('name')->unique(); // Add unique constraint on name
            $table->timestamps(); // Include created_at and updated_at columns
        });

        Schema::create('unit_types', function (Blueprint $table) {
            $table->id(); // Use Laravel's auto-incrementing primary key
            $table->string('name')->unique(); // Add unique constraint on name
            $table->timestamps(); // Include created_at and updated_at columns
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->id(); // Use Laravel's auto-incrementing primary key
            $table->string('name')->unique(); // Add unique constraint on name
            $table->timestamps(); // Include created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('phases');
        Schema::dropIfExists('unit_types');
        Schema::dropIfExists('buildings');
    }
};
