<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->foreignId('currency_buy')->constrained('currencies')->onDelete('cascade');
            $table->foreignId('currency_sell')->constrained('currencies')->onDelete('cascade');
            $table->string('price')->default('0');
            $table->string('min_price')->default('0');
            $table->string('max_price')->default('0');
            $table->string('last_price')->default('0');
            $table->string('volume')->default('0');
            $table->string('change_24')->default('0');
            $table->string('average_24')->default('0');
            $table->enum('market', \App\Helpers\Helper::markets())->default(\App\Helpers\Helper::markets()[0]);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('markets');
    }
}
