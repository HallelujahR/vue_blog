<?php

use Illuminate\Support\Facades\Schema;
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
            $table->integer('uid');
            $table->longText('pic');
            $table->string('title');
            $table->longText('article');
            $table->string('topicid');
            $table->integer('comment_count')->default(0);
            $table->integer('agree_count')->default(0);
            $table->integer('is_delete')->default(0);
            $table->integer('is_comment')->default(0);
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
