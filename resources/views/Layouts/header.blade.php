<header>
    @auth
    <h1><a href="{{ route('home') }}">投稿アプリ</a></h1>
    <ul>
        <li><a href="{{ route('mypost') }}">自分の記事</a></li>
        <li><form action="{{ route('logout') }}" method="post">@csrf<input type="submit" value="ログアウトする"></form></li>
    </ul>
    @endauth
    @guest
    <h1><a href="{{ route('top') }}">投稿アプリ</a></h1>
    <ul>
        <li><a href="{{ route('register') }}">会員登録</a></li>
        <li><a href="{{ route('login') }}">ログイン</a></li>
    </ul>
    @endguest
</header>