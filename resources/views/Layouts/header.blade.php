<header>
    <h1><a href="{{ route('home') }}">投稿サイト</a></h1>
    <ul>
        <li><form action="{{ route('logout') }}" method="post">@csrf<input type="submit" value="ログアウトする"></form></li>
    </ul>
</header>