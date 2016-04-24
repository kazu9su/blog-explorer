# Blog-explorer

## Introduction

### 動作環境

#### 推奨(確認ができている)環境

```vim
Ubuntu : 14.04
PHP : 5.5.9
MySQL : 8.42
Apache : 2.4.7
Git : 2.6.4
```

* このうち、PHPのバージョンは5.5.9以上であることが必須です。

### Laravelについて
本ソースは、Laravel5.2を元に作成しています。  
Laravelについては、  
* [日本語版ドキュメント](http://readouble.com/laravel/5/1/ja/)
* [本家ドキュメント](https://laravel.com/docs/5.2)

をご参照ください。

### ソースコードのセットアップ

```shell
# /var/www/htmlなどの、ベースディレクトリ以下に移動し、git cloneを行ってください
$ cd /path/to/code //move to your base directory
$ git clone git@github.com:kazu9su/blog-explorer.git

# 必須モジュールのインストール
$ cd blog-explorer
$ ./composer.phar install

# ログ、キャッシュデュレクトリの権限変更
$ chmod -R 777 storage/
$ chmod -R 777 bootstrap/cache/
```

### コンフィグ設定
`.env.example` ファイルから、 `.env` を作成してください。  
その後、アプリケーションのキーを作成するコマンドを実行します。
`.env`ファイルに、APP_KEYとして設定されます。

```shell
$ cd /path/to/code/blog-explorer
$ mv .env.example .env
$ php artisan key:generate
```

` .env ` ファイルには、使用するデータベース等の情報を設定します。  
このうち、データベースの設定は必須です。  
* 使用するデータベースの種類
* ホスト
* ユーザ
* パスワード  

```vim
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=example
DB_USERNAME=test
DB_PASSWORD=test
```

### マイグレーション
データベースのマイグレーションを行います。  
以下コマンドを実行するとテーブル、インデックスが作成されます。
作成するテーブルについての情報は、   [database/migrations/2016_04_23_121050_create_rss_histories_table.php](https://github.com/kazu9su/blog-explorer/blob/master/database/migrations/2016_04_23_121050_create_rss_histories_table.php)  
を御覧ください。

```shell
$ cd /path/to/code/blog-explorer
$ php artisan migrate
```

### cronの設定
以下設定を追加してください。  
`/path/to/code/` には、任意のベースディレクトリを設定してください。  
rootユーザでない場合、 `/etc/crontab`を編集できないので、 `crontab -e` コマンドで設定を行ってください。

```vim
* * * * * /usr/bin/php /path/to/code/blog-explorer/artisan schedule:run >> /dev/null 2>&1
```

### ページの表示
お疲れ様でした!  
`http://your-site-url-web-directory/blog-explorer/public/`  
にアクセスしてみてください。FC2のRSS一覧が表示されます。

## タスクの設定
5分に一回RSSを更新するタスクと、2ヶ月以上古い記事を消すタスクは、  
[app/Console/Kernel.php](https://github.com/kazu9su/blog-explorer/blob/master/app/Console/Kernel.php)  
で行っています。  
設定を変更する場合は[こちら](http://readouble.com/laravel/5/1/ja/scheduling.html)を御覧ください。

## テストについて
* Notice  
テストは、実際のテーブルを利用して実行されます。運用開始している環境での実行には十分に注意してください  。

テストは、 下記コマンドで実行できます。

```shell
$ cd /path/to/code/blog-explorer
$ ./vendor/bin/phpunit
```

あるいは、 `make` コマンドがインストールされていれば下記コマンドでもOKです。
```shell
$ cd /path/to/code/blog-explorer
$ make test
```
