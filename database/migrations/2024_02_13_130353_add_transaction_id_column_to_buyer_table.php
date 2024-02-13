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
        Schema::table('buyer', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('order_id');
            $table->json('epg_json_response')->nullable()->after('transaction_id');
            // Use longText instead of json if server mysql older versions
            // $table->longText('epg_json_response')->nullable()->after('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyer', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
            $table->dropColumn('epg_json_response');
        });
    }
};
