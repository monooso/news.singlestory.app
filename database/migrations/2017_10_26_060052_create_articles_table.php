<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('external_id');
            $table->string('title');
            $table->text('abstract');
            $table->string('byline');
            $table->string('url');
            $table->integer('popularity')->unsigned();
            $table->integer('period')->unsigned();
            $table->timestamp('retrieved_at')->useCurrent();

            $table->index('external_id');
            $table->index(['period', 'retrieved_at']);
            $table->index('popularity');
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
