<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buyer_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id');
            $table->string('payment_status')->nullable();
            $table->json('payment_json_response')->nullable(); // Use 'longText' instead of json if server mysql older versions
            $table->timestamps();
        });

        Schema::table('buyer_payments', function (Blueprint $table) {
            if(Schema::hasTable('buyer')) {
                $table->foreign('buyer_id')->references('buyer_id')->on('buyer')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_payments');
    }
};
