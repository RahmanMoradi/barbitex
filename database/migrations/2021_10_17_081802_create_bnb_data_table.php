<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBnbDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('bnb_data', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedInteger('user_id')->nullable();
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->string('address_base_58');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bnb_data');
    }
}
