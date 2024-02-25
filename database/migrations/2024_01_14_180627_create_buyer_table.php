<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerTable extends Migration
{
    public function up()
    {
        Schema::create('buyer', function (Blueprint $table) {
            $table->id('buyer_id');
            $table->integer('buyer_type');
            $table->string('buyers_name');
            $table->date('dob')->nullable(); // Date of Birth
            $table->string('gender')->nullable(); // Gender
            $table->bigInteger('mobile_no');
            $table->string('email_id');
            $table->string('address');
            $table->string('country')->nullable(); // Country
            $table->string('passport_number')->nullable(); // Passport Number
            $table->string('emirates_id')->nullable(); // Emirates ID
            $table->string('project')->nullable();
            $table->string('phase')->nullable();
            $table->string('unit_no')->nullable();
            $table->string('passport_path')->nullable();
            $table->string('emirates_id_path')->nullable();
            $table->string('mou_doc_path')->nullable();
            $table->string('company_name')->nullable();
            $table->string('tl_no')->nullable();
            $table->string('trade_license_path')->nullable();
            $table->tinyInteger('is_primary_buyer')->default(1);
            $table->string('building')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buyer');
    }
}

