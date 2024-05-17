<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_orders', function (Blueprint $table) {
            $table->id();
            $table->string('market_order_id')->unique();
            $table->foreignId('market_id')->constrained('markets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('count');
            $table->string('price');
            $table->string('sumPrice');
            $table->string('remaining');
            $table->enum('type', ['sell', 'buy'])->default('buy');
            $table->enum('status', ['init', 'done', 'cancel'])->default('init');
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
        Schema::dropIfExists('market_orders');
    }
}
