<?php

// デフォルトのコメント部分は省略

Route::get('/', 'TasksController@index');

Route::resource('tasks', 'TasksController');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
});
