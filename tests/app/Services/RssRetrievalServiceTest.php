<?php

use App\Services\RssRetrievalService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class RssRetrievalServiceTest extends TestCase
{
    public function test_get_userName()
    {
        $t = new RssRetrievalService(new Client());
        $link = 'http://meguiruka.blog71.fc2.com/blog-entry-404.html';

        $this->assertEquals('meguiruka', $t->getUserName($link));
    }

    public function test_get_userName_when_is_not_default_format()
    {
        $t = new RssRetrievalService(new Client());
        $link = 'http://eroguya.com/blog-entry-522.html';

        $this->assertEquals('eroguya', $t->getUserName($link));
    }

    public function test_get_server()
    {
        $t = new RssRetrievalService(new Client());
        $link = 'http://meguiruka.blog71.fc2.com/blog-entry-404.html';

        $this->assertEquals('71', $t->getServer($link));
    }

    public function test_get_server_when_number_unspecified()
    {
        $t = new RssRetrievalService(new Client());
        $link = 'http://meguiruka.blog.fc2.com/blog-entry-404.html';

        $this->assertEquals(0, $t->getServer($link));
    }

    public function test_get_server_when_is_not_default_format()
    {
        $t = new RssRetrievalService(new Client());
        $link = 'http://eroguya.com/blog-entry-522.html';

        $this->assertEquals('', $t->getServer($link));
    }

    public function test_get_entryNumber()
    {
        $t = new RssRetrievalService(new Client());
        $link = 'http://meguiruka.blog71.fc2.com/blog-entry-404.html';

        $this->assertEquals('404', $t->getEntryNumber($link));
    }

    public function test_retrieve()
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], file_get_contents(__DIR__ . '/../../stub/sample.rdf')),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $t = new RssRetrievalService($client);

        $this->assertEquals($t->retrieve(), [
            [
                'title' => ' 変わり筆&amp;筆ペン教室 ',
                'description' => ' 皆さんこんばんは(⌒▽⌒)今日は結工房での変わり筆教室。生徒さんの作 ',
                'link' => 'http://keisen87.blog7.fc2.com/blog-entry-970.html',
                'date' => '2016-04-19T19:33:38+09:00',
                'user' => 'keisen87',
                'server' => '7',
                'entry_number' => '970',
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
            [
                'title' => ' 早起きは無理。 ',
                'description' => ' フォリッジグリーン行くつもりでしたが起きたとき全然疲れが取れてなか ',
                'link' => 'http://eroguya.com/blog-entry-522.html',
                'date' => '2016-04-19T19:33:01+09:00',
                'user' => 'eroguya',
                'server' => '',
                'entry_number' => '522',
            ],
        ]);
    }

    function test_saveHistory()
    {
        $t = app('App\Services\RssRetrievalService');
        $t->saveRssHistory([
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

        $this->seeInDatabase('rss_histories', ['user' => 'eroguya']);

        $this->assertEquals(1, DB::table('rss_histories')->where('user', 'lagrandelue')->count(), '重複して登録しない');
    }

    function fixture_1()
    {
        DB::table('rss_histories')->insert([
            'title' => ' 『 CREATOUS MAGAZINE COLLECTION vol.7 』 日時 : 2016.4.22(金) 場所 : 大阪市中央公会堂 開演 : 1部 / 開場 15:00 開演 15:30 2 ',
            'description' => ' いよいよです！ヨウジヤマモト社の知り合いの方より頑張ってとお声かけ ',
            'link' => 'http://lagrandelue.blog.fc2.com/blog-entry-4317.html',
            'date' => '2016-04-19T19:33:08+09:00',
            'user' => 'lagrandelue',
            'server' => '0',
            'entry_number' => '4317',
        ]);
    }
}