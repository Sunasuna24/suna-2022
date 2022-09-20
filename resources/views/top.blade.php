<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿サイトへようこそ</title>
</head>
<body>
    <header>
        <h1>投稿サイト</h1>
        <ul>
            <li><a href="{{ route('register') }}">会員登録</a></li>
            <li><a href="{{ route('login') }}">ログイン</a></li>
        </ul>
    </header>
    <main>
        <p>ようこそ、投稿サイトへ</p>
    </main>
    <footer>
        <span>&copy;Tomoyasu Sunagawa 2022.</span>
    </footer>
</body>
</html>