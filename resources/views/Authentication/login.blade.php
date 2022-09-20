@extends('Layouts.app')

@section('title', 'ログイン | 投稿アプリ')

@section('content')
<form action="{{ route('login') }}" method="post">
    @csrf
    <h2>ログイン</h2>
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
    @if (session('error_status'))
    <p>{{ session('error_status') }}</p>
    @endif
    <div>
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
    </div>
    <div>
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password">
    </div>
    <button type="submit">送信する</button>
</form>
@endsection