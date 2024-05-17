<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('users');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique()->nullable();
            $table->string('national_code')->unique()->nullable();
            $table->string('birthday')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('address')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->timestamp('doc_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('two_factor_type', ['none', 'email', 'sms', 'google'])->default('none');
            $table->string('google2fa_secret')->nullable();
            $table->boolean('is_code_set')->default(0);
            $table->string('api_token', 60)->nullable();
            $table->string('max_buy')->default('5000000');
            $table->string('day_buy')->default('0');
            $table->enum('level', ['bronze', 'silver', 'gold'])->default('bronze');
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
        Schema::dropIfExists('users');
    }
}
