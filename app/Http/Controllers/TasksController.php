<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $user = \Auth::user();
        $tasks = $user->tasks()->get();

        // タスク一覧ビューでそれを表示
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
         $task = new Task;

        // タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }
    
    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション
         $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
         ]);
        
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
         $request->user()->tasks()->create([
             'status' => $request->status,
             'content' => $request->content,
         ]);

        // トップページへリダイレクトさせる
        return redirect('/');
    }
    
    // getでtasks/（任意のid）にアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
    
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、viewを表示
        if (\Auth::id() === $task->user_id){
            return view('tasks.show', [
              'task' => $task,
            ]);
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // getでtasks/（任意のid）/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
    
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、viewを表示
        if (\Auth::id() === $task->user_id){
            return view('tasks.edit', [
              'task' => $task,
            ]);
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // putまたはpatchでtasks/（任意のid）にアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);

        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
        // // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、メッセージを更新
        if (\Auth::id() === $task->user_id){
            $task->status = $request->status;    // 追加
            $task->content = $request->content;
            $task->save();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // deleteでtasks/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $task = Task::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        // 前のURLへリダイレクトさせる
        return back();
    }
}