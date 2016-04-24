<?php

use GuzzleHttp\Client;

class RetrieveRssTest extends TestCase
{
    function test_handle()
    {
        $m = Mockery::mock('App\Services\RssRetrievalService[retrieve]', [new Client()]);
        $m->shouldReceive('retrieve')->once()->andReturn([
            [
                'title' => ' 早起きは無理。 ',
                'description' => ' フォリッジグリーン行くつもりでしたが起きたとき全然疲れが取れてなか ',
                'link' => 'http://eroguya.com/blog-entry-522.html',
                'date' => '2016-04-19T19:33:01+09:00',
                'user' => 'eroguya',
                'server' => '',
                'entry_number' => '522',
            ],
            [
                'title' => ' 『 CREATOUS MAGAZINE COLLECTION vol.7 』 日時 : 2016.4.22(金) 場所 : 大阪市中央公会堂 開演 : 1部 / 開場 15:00 開演 15:30 2 ',
                'description' => ' いよいよです！ヨウジヤマモト社の知り合いの方より頑張ってとお声かけ ',
                'link' => 'http://lagrandelue.blog.fc2.com/blog-entry-4317.html',
                'date' => '2016-04-19T19:33:08+09:00',
                'user' => 'lagrandelue',
                'server' => '0',
                'entry_number' => '4317',
            ],
        ]);

        $t = app('App\Console\Commands\RetrieveRss', [$m]);

        $t->handle();

        $this->seeInDatabase('rss_histories', ['user' => 'eroguya']);
        $this->seeInDatabase('rss_histories', ['user' => 'lagrandelue']);
    }
}
