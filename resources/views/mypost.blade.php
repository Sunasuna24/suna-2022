@extends('Layouts.app')

@section('title', '自分の記事 | 投稿アプリ')

@section('content')
@if (count($posts) === 0)
<p>まだ投稿がありません。</p>
@else
<table>
    <tr>
        <th>タイトル</th>
        <th>本文</th>
    </tr>
    @foreach ($posts as $post)
    <tr>
        <td><a href="">{{ $post->title }}</a></td>
        <td>{{ $post->body }}</td>
    </tr>
    @endforeach
</table>
@endif
@endsection