@extends('Layouts.app')

@section('title', '会員登録 | 投稿サイト')

@section('content')
<form action="{{ route('register') }}" method="post">
    @csrf
    <h2>会員登録</h2>
    @if ($errors)
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
    @endif
    <div>
        <label for="username">ユーザー名</label>
        <input type="text" name="username" id="username">
    </div>
    <div>
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email">
    </div>
    <div>
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password">
    </div>
    <div>
        <label for="password_confirmation">(確認)パスワード</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
    </div>
    <button type="submit">送信する</button>
</form>
@endsection