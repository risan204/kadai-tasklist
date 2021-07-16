@extends('layouts.app')

@section('content')

   <h1>id: {{ $message->id }} のメッセージ編集ページ</h1>

    {!! Form::model($message, ['route' => ['messages.update', $message->id], 'method' => 'put']) !!}