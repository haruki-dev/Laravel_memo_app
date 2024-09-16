<!-- <!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ToDo App</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<header>
  <nav class="my-navbar">
    <a class="my-navbar-brand" href="/">ToDo App</a>
  </nav>
</header>
<main> -->



<!--
*   extends：親ビューを継承する（読み込む）
*   親ビュー名：layout を指定
-->
@extends('layout')

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：scripts を指定
*   用途：javascriptライブラリー「flatpickr」のスタイルシートを指定
-->
@section('styles')
    <!-- 「flatpickr」の デフォルトスタイルシートをインポート -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- 「flatpickr」の ブルーテーマの追加スタイルシートをインポート -->
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
@endsection

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：content を指定
*   用途：タスクを追加するページのHTMLを表示する
-->
@section('content')
  <div class="container">
    <div class="row">
    <div class="col col-md-4">
      <nav class="panel panel-default">
          <div class="panel-heading">フォルダ</div>
          <div class="panel-body">
            <a href="{{ route('folders.create') }}" class="btn btn-default btn-block">
              フォルダを追加する
            </a>
          </div>
          <div class="list-group">
            <table class="table folder-table">
              @foreach($folders as $folder)
                @if($folder->user_id === Auth::user()->id)  
                  <tr>
                    <td>
                      <a href="{{ route('tasks.index', ['folder' => $folder->id]) }}" class="list-group-item {{ $folder_id === $folder->id ? 'active' : ''}}">
                      {{-- <a href="{{ route('tasks.index', ['id' => $folder->id]) }}" class="list-group-item {{ $folder_id === $folder->id ? 'active' : ''}}"> --}}
                        {{ $folder->title }}
                      </a>
                    </td>
                    <td><a href="{{ route('folders.edit', ['folder' => $folder->id]) }}">編集</a></td>
                    <td><a href="{{ route('folders.delete', ['folder' => $folder->id]) }}">削除</a></td>
                  </tr>
                @endif
              @endforeach
            </table>
          </div>
        </nav>
      </div>
      <div class="column col-md-8">
      <!-- ここにタスクが表示される -->
      <div class="panel panel-default">
    <div class="panel-heading">タスク</div>
    <div class="panel-body">
        <div class="text-right">
            <a href="{{ route('tasks.create', ['folder' => $folder_id]) }}" class="btn btn-default btn-block">
                タスクを追加する
            </a>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>状態</th>
                <th>期限</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>
                      <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                      <!-- <span class='label'>{{ $task->status_label }}</span> -->
                        <!-- <span class="label">{{ $task->status }}</span> -->
                    </td>
                    <td>{{ $task->formatted_due_date }}</td>
                    <!-- <td>{{ $task->due_date }}</td> -->
                    <td><a href="{{ route('tasks.edit', ['folder' => $task->folder_id, 'task' => $task->id]) }}">編集</a></td>
                    <td><a href="{{ route('tasks.delete', ['folder' => $task->folder_id, 'task' => $task->id]) }}">削除</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
      </div>
    </div>
  </div>
@endsection

</main>
</body>
</html>
