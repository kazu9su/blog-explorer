<?php

use Carbon\Carbon;

class DeleteRssTest extends TestCase
{
    function test_handle()
    {
        Carbon::setTestNow(Carbon::parse('2016-4-24'));
        $this->fixture_1();
        $t = app('App\Console\Commands\DeleteRss');
        $t->handle();
        
        $this->dontSeeInDatabase('rss_histories', ['user' => 'keisen87']);
        $this->seeInDatabase('rss_histories', ['user' => 'lagrandelue']);
    }

    function fixture_1()
    {
        DB::table('rss_histories')->insert([
            'title' => 'hogehoge',
            'link' => 'http://keisen87.blog7.fc2.com/blog-entry-970.html',
            'date' => Carbon::now()->subMonth(1)->toIso8601String(), //1ヶ月前
            'user' => 'keisen87',
            'server' => '7',
            'entry_number' => '970',
        ]);

        DB::table('rss_histories')->insert([
            'title' => 'fugafuga',
            'link' => 'http://lagrandelue.blog18.fc2.com/blog-entry-4317.html',
            'date' => Carbon::now()->toIso8601String(),
            'user' => 'lagrandelue',
            'server' => '18',
            'entry_number' => '4317',
        ]);
    }
}
