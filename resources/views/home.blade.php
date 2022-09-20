<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿サイト</title>
</head>
<body>
    <header>
        <h1>投稿サイト</h1>
        <ul>
            <li><form action="{{ route('logout') }}" method="post">@csrf<input type="submit" value="ログアウトする"></form></li>
        </ul>
    </header>
    <main>
        <p>ホーム画面です。</p>
    </main>
    <footer>
        <span>&copy;Tomoyasu Sunagawa 2022.</span>
    </footer>
</body>
</html>