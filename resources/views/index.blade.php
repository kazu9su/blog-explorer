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

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
<ol class="breadcrumb">
    <li><a href="#">RSS explorer presented by Tommy</a></li>
</ol>
<div class="container-fluid">

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">RSS feeds</div>
        <div class="panel-body">
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
    <script>
        $(document).foundation();
    </script>

</body>
</html>