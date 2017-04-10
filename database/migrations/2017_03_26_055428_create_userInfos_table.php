<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userInfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid',32)->unique();
            $table->string('userName')->unique();
            $table->string('email');
            $table->string('token')->unique();
            $table->string('phone');
            $table->string('ctime');
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
        Schema::drop('userInfo');
    }
}
