@extends('Layouts.app')

@section('title', '投稿アプリ')

@section('content')
<p>ホーム画面です。</p>
<table>
    <tr>
        <th>タイトル</th>
        <th>本文</th>
    </tr>
    @foreach ($posts as $post)
    <tr>
        <td><a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a></td>
        <td>{{ $post->body }}</td>
    </tr>
    @endforeach
</table>
@endsection