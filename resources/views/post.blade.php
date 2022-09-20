@extends('Layouts.app')

@section('title', '記事を作成する | 投稿アプリ')

@section('content')
<form action="{{ route('post.create') }}" method="post">
    @csrf
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
    <div>
        <input type="text" name="title" placeholder="タイトル" value="{{ old('title') }}">
    </div>
    <div>
        <textarea name="body" cols="30" rows="10" placeholder="こちらに本文">{{ old('body') }}</textarea>
    </div>
    <div>
        <label for="status">公開する</label>：<input type="checkbox" name="status" id="status" value="1" {{ old('status') ? 'checked' : '' }}>
    </div>
    <button type="submit">送信する</button>
</form>
@endsection