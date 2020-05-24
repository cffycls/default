<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('password');
            $table->text('intro')->comment('个人简介')->nullable();
            $table->string('city')->nullable();
            $table->enum('gender', ['男','女','保密'])->default('保密');
            $table->dateTime('birthday')->default('2000-01-01 00:00:00');
            $table->integer('group_id')->comment('分组id');
            $table->ipAddress('ip_address')->comment('上次登录IP')->nullable();
            $table->string('token')->comment('数据验证')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
