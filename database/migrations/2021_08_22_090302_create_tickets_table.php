<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('order_id')->nullable()->constrained('market_orders');
            $table->foreignId('ticket_id')->nullable()->constrained('tickets');
            $table->foreignId('category_id')->nullable()->constrained('ticket_categories');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('file')->nullable();
            $table->enum('status', ['new', 'process', 'user', 'admin', 'close'])->default('new')->nullable();
            $table->enum('role', ['user', 'admin'])->default('user');
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
        Schema::dropIfExists('tickets');
    }
}
