@extends('Layouts.app')

@section('title', '記事を作成する | 投稿アプリ')

@section('content')
<form action="{{ route('post.create') }}" method="post">
    @csrf
</form>
@endsection