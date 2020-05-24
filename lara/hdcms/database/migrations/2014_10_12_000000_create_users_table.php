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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('twitter_account')->comment('Twitter 帐号')->nullable();
            $table->string('github_name')->comment('github')->nullable();
            $table->string('linkedin')->comment('LinkedIn')->nullable();
            $table->string('personal_website')->comment('个人网站')->nullable();
            $table->string('wechat_qrcode')->comment('微信账号二维码')->nullable();
            $table->string('wechat_payment_qrcode')->comment('微信支付二维码')->nullable();
            $table->string('introduction')->comment('个人简介')->nullable();
            $table->text('signature')->comment('署名')->nullable();

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
