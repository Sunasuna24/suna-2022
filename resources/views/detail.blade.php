@extends('Layouts.app')

@section('title', '記事の詳細 | 投稿アプリ')

@section('content')
<form action="{{ route('post.show', $post->id) }}" method="post">
    @csrf
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
    @if (session('success_status'))
    <p>{{ session('success_status') }}</p>
    @endif
    <div>
        <input type="text" name="title" value="{{ old('title', $post->title) }}" {{ $post->user_id !== \Auth::id() ? 'readonly' : '' }}> - <span>{{ $post->user->name }}</span>
    </div>
    <div>
        <textarea name="body" cols="30" rows="10" {{ $post->user_id !== \Auth::id() ? 'readonly' : '' }}>{{ old('body', $post->body)  }}</textarea>
    </div>
    <div>
        <input type="checkbox" name="status" id="status" value="1" {{ $post->status ? 'checked' : '' }} {{ $post->user_id !== \Auth::id() ? 'disabled' : '' }}><label for="status">公開する</label>
    </div>
    <button type="submit" {{ $post->user_id !== \Auth::id() ? 'disabled' : '' }}>送信する</button>
</form>
@endsection