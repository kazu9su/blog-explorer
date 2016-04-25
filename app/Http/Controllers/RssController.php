<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\RssHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

/**
 * Class RssController
 * @package App\Http\Controllers
 */
class RssController extends Controller
{
    /**
     * @var array
     */
    static $searchConditions = [
        'link',
        'from_date',
        'to_date',
        'user',
        'server',
        'from_date',
        'entry_number',
    ];

    /**
     * @var RssHistory
     */
    protected $rssHistory;

    /**
     * RssController constructor.
     * @param RssHistory $rssHistory
     */
    public function __construct(RssHistory $rssHistory)
    {
        $this->rssHistory = $rssHistory;
    }

    /**
     * クッキーに保存されている検索条件にしたがってRSSを表示する。
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!is_null($link = $request->cookie('link'))) {
            $this->rssHistory = $this->rssHistory->where('link', 'like', "%$link%");
        }
        if (!is_null($date = $request->cookie('from_date'))) {
            $this->rssHistory = $this->rssHistory->whereDate('date', '>=', Carbon::parse($date)->toIso8601String());
        }
        if (!is_null($date = $request->cookie('to_date'))) {
            $this->rssHistory = $this->rssHistory->whereDate('date', '<=', Carbon::parse($date)->toIso8601String());
        }
        if (!is_null($user = $request->cookie('user'))) {
            $this->rssHistory = $this->rssHistory->where('user', 'like', "%$user%");
        }
        if (!is_null($server = $request->cookie('server'))) {
            $this->rssHistory = $this->rssHistory->where('server', "$server");
        }
        if (!is_null($entryNumber = $request->cookie('entry_number'))) {
            $this->rssHistory = $this->rssHistory->where('entry_number', '>', $entryNumber);
        }

        $rssHistories = $this->rssHistory->orderBy('date', 'desc')->paginate(10);

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
            //条件が設定されていればクッキーにセット。指定されていなければ削除
            if (isset($inputs[$condition]) && $inputs[$condition] != '') {
                $response = $response->withCookie($condition, $inputs[$condition]);
            } else {
                $response = $response->withCookie(Cookie::forget($condition));
            }
        }

        return $response->withInput();
    }
}
