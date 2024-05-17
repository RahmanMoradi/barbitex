<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique()->nullable();
            $table->string('password');
            $table->enum('two_factor_type', ['none', 'email', 'sms', 'google'])->default('none');
            $table->string('google2fa_secret')->nullable();
            $table->boolean('is_code_set')->default(0);
            $table->string('api_token', 60)->nullable();
            $table->enum('theme', ['light', 'dark'])->default('light');
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
