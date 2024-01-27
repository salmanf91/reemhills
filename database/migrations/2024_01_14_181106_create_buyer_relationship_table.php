<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerRelationshipTable extends Migration
{
    public function up()
    {
        Schema::create('buyer_relationship', function (Blueprint $table) {
            $table->foreignId('primary_buyer_id')->constrained('buyer', 'buyer_id')->onDelete('cascade');
            $table->foreignId('secondary_buyer_id')->constrained('buyer', 'buyer_id')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['primary_buyer_id', 'secondary_buyer_id']);
            $table->index('secondary_buyer_id');
            $table->index(['primary_buyer_id', 'secondary_buyer_id'], 'idx_buyer_pair');
        });
    }

    public function down()
    {
        Schema::dropIfExists('buyer_relationship');
    }
}




