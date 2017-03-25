<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('title');
            $table->text('article');
            $table->string('userName');
            $table->string('category');
            $table->string('tag1',20)->default(null);
            $table->string('tag2',20)->default(null);
            $table->string('tag3',20)->default(null);
            $table->string('tag4',20)->default(null);
            $table->string('tag5',20)->default(null);
            $table->integer('views')->default(0);
            $table->integer('collections')->default(0);
            $table->integer('comnments')->default(0);
            $table->string('power')->default('public');
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
        Schema::drop('articles');
    }
}
