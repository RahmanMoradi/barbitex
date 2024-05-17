<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->string('coin');
            $table->string('network');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('tag')->nullable();
            $table->string('qr_address')->nullable();
            $table->string('qr_tag')->nullable();
            $table->string('addressRegex');
            $table->string('memoRegex')->nullable();
            $table->string('withdrawFee');
            $table->string('withdrawMin');
            $table->string('withdrawMax');
            $table->string('minConfirm');
            $table->string('explorer')->nullable();
            $table->boolean('isDefault');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('networks');
    }
}
