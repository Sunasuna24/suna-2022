@extends('Layouts.app')

@section('title', '記事の詳細 | 投稿アプリ')

@section('content')
<form action="{{ route('posts') }}" method="post">
    @csrf
    <div>
        <input type="text" name="title" placeholder="タイトル">
    </div>
    <div>
        <textarea name="body" cols="30" rows="10" placeholder="こちらに本文"></textarea>
    </div>
    <div>
        <label for="status">公開する</label>：<input type="checkbox" name="status" id="status">
    </div>
    <button type="submit">送信する</button>
</form>
@endsection