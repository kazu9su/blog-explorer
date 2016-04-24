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
            $table->string('title')->default('');
            $table->string('description')->default('');
            $table->string('link')->default('');
            $table->timestampTz('date');
            $table->string('user')->default('');
            $table->string('server')->default('');
            $table->integer('entry_number')->default(0);
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
