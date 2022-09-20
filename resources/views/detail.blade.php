@extends('Layouts.app')

@section('title', '記事の詳細 | 投稿アプリ')

@section('content')
<form action="{{ route('post.show', $post->id) }}" method="post">
    @csrf
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
    <div>
        <input type="text" name="title" value="{{ old('title', $post->title) }}"> - <span>{{ $post->user->name }}</span>
    </div>
    <div>
        <textarea name="body" cols="30" rows="10">{{ old('body', $post->body)  }}</textarea>
    </div>
    <div>
        <input type="checkbox" name="status" id="status" {{ $post->status ? 'checked' : '' }}><label for="status">公開する</label>
    </div>
    <button type="submit">送信する</button>
</form>
@endsection