<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | 投稿アプリ</title>
</head>
<body>
    <header>
        <h1>ログインする</h1>
    </header>
    <main>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div>
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password">
            </div>
            <button type="submit">送信する</button>
        </form>
    </main>
    <footer>
        <span>&copy;Tomoyasu Sunagawa 2022.</span>
    </footer>
</body>
</html>