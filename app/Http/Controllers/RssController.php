<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\RssHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class RssController extends Controller
{
    static $searchConditions = [
        'link',
        'from_date',
        'to_date',
        'user',
        'server',
        'from_date',
    ];

    /**
     * クッキーに保存されている検索条件にしたがってRSSを表示する。
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rssHistories = new RssHistory();
        if (!is_null($link = $request->cookie('link'))) {
            $rssHistories = $rssHistories->where('link', 'like', "%$link%");
        }
        if (!is_null($date = $request->cookie('from_date'))) {
            $rssHistories = $rssHistories->whereDate('date', '>=', Carbon::parse($date)->toIso8601String());
        }
        if (!is_null($date = $request->cookie('to_date'))) {
            $rssHistories = $rssHistories->whereDate('date', '<=', Carbon::parse($date)->toIso8601String());
        }
        if (!is_null($user = $request->cookie('user'))) {
            $rssHistories = $rssHistories->where('user', 'like', "%$user%");
        }
        if (!is_null($server = $request->cookie('server'))) {
            $rssHistories = $rssHistories->where('server', "$server");
        }
        if (!is_null($entryNumber = $request->cookie('from_date'))) {
            $rssHistories = $rssHistories->where('entry_number', '>', $entryNumber);
        }

        $rssHistories = $rssHistories->orderBy('date', 'desc')->paginate(10);

        return view('index', compact('rssHistories'));
    }

    /**
     * 検索条件をクッキーにセットする
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function search(Request $request)
    {
        $inputs = $request->all();
        $response = redirect()->route('index');

        foreach (self::$searchConditions as $condition) {
            if ($inputs[$condition] != '') {
                $response = $response->withCookie($condition, $inputs[$condition]);
            } else {
                $response = $response->withCookie(Cookie::forget($condition));
            }
        }

        return $response->withInput();
    }
}
