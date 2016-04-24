<?php

use App\Http\Controllers\RssController;
use Carbon\Carbon;

class RssControllerTest extends TestCase
{
    function test_index_view()
    {
        $testNow = Carbon::parse('20160424');
        Carbon::setTestNow($testNow);
        $this->fixture_1();
        $this->visit('/')
            ->see('RSS Explorer')
            ->see('hogehoge')
            ->see('http://keisen87.blog7.fc2.com/blog-entry-970.html')
            ->see($testNow->format('Y-m-d H:i:s'))
            ->see('7')
            ->see('970')
        ;
    }

    function test_redirect_when_press_search_btn()
    {
        $testNow = Carbon::parse('20160424');
        Carbon::setTestNow($testNow);
        $this->fixture_1();
        $this->visit('/')
            ->type('keisen87', 'user')
            ->press('Search')
            ->seePageIs('/')
        ;
    }

    function test_index_with_cookies()
    {
        $testNow = Carbon::parse('20160424');
        Carbon::setTestNow($testNow);
        $this->fixture_1();
        $this->fixture_2();

        //specify user
        $response = $this->call('GET', '/')->withCookie('user', 'lagrandelue');

        $this->assertNotRegExp('/^keisen87/', $response->content());
    }

    function test_search()
    {
        Session::start();
        $params = [
            '_token' => csrf_token(), // Retrieve current csrf token
            'user' => 'hogehoge',
        ];
        
        $response = $this->call('POST', '/search', $params);
        $this->assertEquals(302, $response->status());
        $expected = RssController::$searchConditions;
        $expected[] = 'XSRF-TOKEN';

        foreach ($response->headers->getCookies() as $cookie) {
            $this->assertContains($cookie->getName(), $expected);
        }
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

    function fixture_2()
    {
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