<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourceColumnToArticlesTable extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('source', 50)->after('id')->default('');
            $table->index(['source']);
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex(['source']);
            $table->dropColumn(['source']);
        });
    }
}
