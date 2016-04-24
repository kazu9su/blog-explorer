<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRssHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('link');
            $table->timestampTz('date');
            $table->string('user');
            $table->string('server');
            $table->integer('entry_number');
            $table->timestamps();

            //検索に使うカラムにインデックスを作成
            $table->index('link');
            $table->index('date');
            $table->index('user');
            $table->index('server');
            $table->index('entry_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rss_histories');
    }
}
