<?php

use Carbon\Carbon;

class RssHistoryTest extends TestCase
{
    function test_exists()
    {
        $this->fixture_1();
        
        $t = app('App\RssHistory', [[
            'title' => 'hogehoge',
            'link' => 'http://keisen87.blog7.fc2.com/blog-entry-970.html',
            'date' => Carbon::now()->toIso8601String(),
            'user' => 'keisen87',
            'server' => '7',
            'entry_number' => '970',
        ]]);

        $this->assertTrue($t->exists());

        $t = app('App\RssHistory', [[
            'title' => ' 『 CREATOUS MAGAZINE COLLECTION vol.7 』 日時 : 2016.4.22(金) 場所 : 大阪市中央公会堂 開演 : 1部 / 開場 15:00 開演 15:30 2 ',
            'description' => ' いよいよです！ヨウジヤマモト社の知り合いの方より頑張ってとお声かけ ',
            'link' => 'http://lagrandelue.blog.fc2.com/blog-entry-4317.html',
            'date' => '2016-04-19T19:33:08+09:00',
            'user' => 'lagrandelue',
            'server' => '0',
            'entry_number' => '4317',
        ]]);

        $this->assertFalse($t->exists());
    }

    function fixture_1()
    {
        DB::table('rss_histories')->insert([
            'title' => 'hogehoge',
            'link' => 'http://keisen87.blog7.fc2.com/blog-entry-970.html',
            'date' => Carbon::now()->toIso8601String(),
            'user' => 'keisen87',
            'server' => '7',
            'entry_number' => '970',
        ]);
    }
}