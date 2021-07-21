@extends('layouts.app')

@section('content')
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <td>{{ $task->id }}</td>
        </tr>
        <tr>
            <th>ステータス</th>
            <td>{{ $task->status }}</td>
        </tr>
        <tr>
            <th>メッセージ</th>
            <td>{{ $task->content }}</td>
        </tr>
    </table>
            @if (Auth::id() == $user->id)
                {{-- 投稿フォーム --}}
                @include('task.form')
            @endif
            {{-- 投稿一覧 --}}
            @include('task.task')
        </div>
    </div>
@endsection