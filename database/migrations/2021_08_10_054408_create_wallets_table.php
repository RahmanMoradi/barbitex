<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('card_id')->nullable()->constrained('cards')->onDelete('cascade');
            $table->foreignId('network_id')->nullable()->constrained('networks')->onDelete('cascade');
            $table->foreignUuid('currency')->constrained('currencies','symbol');
            $table->string('price');
            $table->text('wallet')->nullable();
            $table->string('tag')->nullable();
            $table->string('service_id')->nullable();
            $table->string('txid')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['increment', 'decrement'])->default('increment');
            $table->enum('status', ['new', 'process', 'done', 'cancel'])->default('new');
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
        Schema::dropIfExists('wallets');
    }
}
