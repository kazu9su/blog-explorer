<?php
namespace App\Services;

use GuzzleHttp\Client;

/**
 * Class RssRetrievalService
 * @package App\Services
 */
class RssRetrievalService
{
    const URL = 'http://blog.fc2.com/newentry.rdf';

    /**
     * @var Client
     */
    protected $client;

    /**
     * RssRetrievalService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function retrieve()
    {
        $response = $this->client->get(self::URL);

        $items = $this->parse($response->getBody()->getContents());

        var_dump($items);
    }

    /**
     * @param string $rdfString
     * @return array
     */
    public function parse($rdfString)
    {
        $parsed = @simplexml_load_string($rdfString);

        $items = [];
        foreach ($parsed->item as $item) {
            $dc = $item->children('http://purl.org/dc/elements/1.1/');
            $items[] = [
                'title' => (string) $item->title,
                'description' => (string) $item->description,
                'link' => $link = (string) $item->link,
                'date' => (string) $dc->date,
                'user' => $this->getUserName($link),
                'server' => $this->getServer($link),
                'entry_number' => $this->getEntryNumber($link),
            ];
        }

        return $items;
    }

    /**
     * @param string $link
     * @return string
     */
    public function getUserName($link)
    {
        //デフォルトフォーマットの場合、サーバ番号を取得できる。
        //それ以外（おそらく個人でドメインを取得している）の場合、ユーザ名は特定できない
        if ($this->isDefaultFormat($link)) {
            $firstBlock = explode('.', $link)[0];

            return explode('//', $firstBlock)[1];
        } else {
            return 'Unknown';
        }
    }

    /**
     * @param string $link
     * @return int|string
     */
    public function getServer($link)
    {
        //デフォルトフォーマットの場合、サーバ番号を取得できる。
        //それ以外（おそらく個人でドメインを取得している）の場合、サーバ番号は特定できない
        if ($this->isDefaultFormat($link)) {
            $secondBlock = explode('.', $link)[1];

            return strlen($secondBlock) == 4 ? 0 : substr($secondBlock, 4);
        } else {
            return 'Unknown';
        }
    }

    /**
     * @param string $link
     * @return mixed
     */
    public function getEntryNumber($link)
    {
        $blocks = explode('/', $link);
        // リンクを 「/」で分割した最後の部分は、pathになるはずである。
        //FC2ブログでは、pathの部分は固定のフォーマット blog-entry-(エントリーナンバー).html であるという仮定
        $path = end($blocks);
        $entry_part = explode('.', $path)[0];

        return explode('-', $entry_part)[2];
    }

    /**
     * linkがデフォルトフォーマットかどうかを返す
     * Default Format : http://ユーザ名.blog(サーバー).fc2.com/blog-entry-(エントリーナンバー).html とする
     * @param string $link
     * @return bool
     */
    public function isDefaultFormat($link)
    {
        $blocks = explode('.', $link);

        //2番目のブロックが、blogから始まれば、デフォルトフォーマットである
        return preg_match('/^blog/', $blocks[1]) ? true : false;
    }
}