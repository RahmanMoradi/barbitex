<?php

use App\Helpers\Helper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('name');
            $table->string('symbol')->index();
            $table->string('explorer')->nullable();
            $table->string('chart_name')->nullable();
            $table->string('price')->default(0);
            $table->string('count')->default(0);
            $table->string('decimal')->default(0);
            $table->string('decimal_size')->default(0);
            $table->string('percent')->nullable();
            $table->integer('position')->nullable();
            $table->enum('type', ['fiat', 'coin'])->default('coin');
            $table->enum('market', Helper::markets())->default(Helper::markets()[0]);
            $table->boolean('active')->default(1);
            $table->text('chart_data')->nullable();
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
        Schema::dropIfExists('currencies');
    }
}
