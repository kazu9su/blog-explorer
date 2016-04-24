<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rss Explorer</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
</head>
<body>
<ol class="breadcrumb">
    <li><a href="#">RSS explorer presented by Tommy</a></li>
</ol>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">RSS explorer</div>
        <div class="panel-body">
            <form class="" role="search" method="POST" action="/blog-explorer/public/index.php/search">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="datetime">時刻</label>
                    <div class="form-inline">
                        <div class="form-group">
                            <input type="datetime" class="form-control date" data-provide="datepicker" name="from_date" value="{{old('from_date')}}">
                        </div>
                        ~
                        <div class="form-group">
                            <input type="datetime" class="form-control date" data-provide="datepicker" name="to_date" value="{{old('to_date')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="text" class="form-control" id="link" placeholder="URL" name="link" value="{{old('link')}}">
                </div>
                <div class="form-group">
                    <label for="user">ユーザ名</label>
                    <input type="text" class="form-control" id="user" placeholder="User." name="user" value="{{old('user')}}">
                </div>
                <div class="form-group">
                    <label for="server">サーバ番号</label>
                    <input type="number" class="form-control" placeholder="ServerNo." name="server" value="{{old('server')}}">
                </div>
                <div class="form-group">
                    <label for="entry_number">エントリーNo</label>
                    <input type="number" class="form-control" placeholder="EntryNo. 指定の番号より新しいエントリーを表示します" name="entry_number" value="{{old('entry_number')}}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <table class="table">
                <thead>
                <tr>
                    <th>日付</th>
                    <th>URL</th>
                    <th>タイトル</th>
                    <th>description</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($rssHistories as $rss)
                    <tr class="pure-table-odd">
                        <td>{{$rss->date}}</td>
                        <td><a href="{{$rss->link}}" target="_blank">{{$rss->link}}</a></td>
                        <td>{{$rss->title}}</td>
                        <td>{{$rss->description}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                <div>{!! $rssHistories->render() !!}</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>