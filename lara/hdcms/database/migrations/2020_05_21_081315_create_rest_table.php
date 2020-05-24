<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rest', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->comment('列名称');
            $table->text('intro')->comment('内容');
            $table->ipAddress('ip_address')->comment('ip');
            $table->time('show_what')->default('2020-05-21 16:53:11')->comment('测试字段'); //16:53:11
            //$table->dateTime('create_at')->default('2020-05-21 16:53:11');
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
        Schema::dropIfExists('rest');
    }
}
