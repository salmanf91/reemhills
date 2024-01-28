<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('buyer', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('is_primary_buyer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('buyer', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
};
