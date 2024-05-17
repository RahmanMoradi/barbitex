<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('admins');
            $table->foreignId('category_id')->constrained('article_categories');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('body');
            $table->text('meta_description');
            $table->text('meta_tag');
            $table->string('image')->nullable();
            $table->boolean('vip')->default('0');
            $table->boolean('show_app')->default('0');
            $table->boolean('discount')->default('0');
            $table->boolean('accreditation')->default('0');
            $table->boolean('reward')->default('0');
            $table->boolean('metaverse')->default('0');
            $table->boolean('analysis')->default('0');
            $table->boolean('airdrop')->default('0');
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
        Schema::dropIfExists('articles');
    }
}
