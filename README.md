# Blog-explorer

## Introduction

### 動作環境

#### 推奨(確認ができている)環境

```vim
Ubuntu 14.04
PHP : 5.5.9
MySQL : 8.42
Apache : 2.4.7
Git : 2.6.4
```

* このうち、PHPは5.5.9以上であることが必須である

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

# アプリケーションのキーを生成
$ php artisan key:generate
```

### コンフィグ設定
` .env ` ファイルに使用するデータベース等の情報を設定します。  
このうち、データベースの設定は必須です。  
* 使用するデータベース
* ユーザ
* パスワード
などを任意で変更してください。

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

```shell
$ cd /path/to/code/blog-explorer
$ php artisan migrate
```

### cronの設定
`/etc/crontab` に以下設定を追加してください。  
ユーザは `root` でない場合、任意の権限を持ったユーザで設定をしてください。

* ユーザを指定しない場合
```vim
# この場合、設定を行ったユーザで実行されます。
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

* ユーザを指定する場合
```vim
* * * * * root php /path/to/artisan schedule:run >> /dev/null 2>&1
```
