<!--
*   extends：親ビューを継承する（読み込む）
*   親ビュー名：layout を指定
-->

@extends('layout')

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：styles を指定
*   用途：javascriptライブラリー「flatpickr」のスタイルシートを指定
-->

@section('styles')
    <!-- 「flatpickr」：デフォルトスタイルシート
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    「flatpickr」：ブルーテーマの追加スタイルシート
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css"> -->
  @include('share.flatpickr.styles')

@endsection

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：content を指定
*   用途：タスクを編集するページのHTMLを表示する
-->

@section('content')
<div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-default">
          <div class="panel-heading">タスクを編集する</div>
          <div class="panel-body">
            @if($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $message)
                  <li>{{ $message }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <form action="{{ route('tasks.edit', ['folder' => $task->folder_id, 'task' => $task->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" class="form-control" name="title" id="title"
                        value="{{ old('title') ?? $task->title }}"
                    />
                </div>
                <div class="form-group">
                    <label for="status">状態</label>
                    <select name="status" id="status" class="form-control">
                        @foreach(\App\Models\Task::STATUS as $key => $val)
                            <option value="{{ $key }}" {{ $key == old('status', $task->status) ? 'selected' : '' }}>
                                {{ $val['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="due_date">期限</label>
                    <input type="text" class="form-control" name="due_date" id="due_date" value="{{ old('due_date') ?? $task->formatted_due_date }}" />
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">送信</button>
                </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection


<!--
*   section：子ビューで定義したデータを表示する
*   セクション名：scripts を指定
*   目的：flatpickr によるカレンダー形式による日付選択
*   用途：javascriptライブラリー「flatpickr」のインポート
-->

@section('scripts')
<!-- <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
<script>
    flatpickr(document.getElementById('due_date'), {
        locale: 'ja',
        dateFormat: "Y/m/d",
        minDate: new Date()
    });
</script> -->
  @include('share.flatpickr.scripts')
@endsection