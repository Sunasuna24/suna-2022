<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録 | 投稿サイト</title>
</head>
<body>
    <header>
        <h1><a href="{{ route('top') }}">投稿サイト</a></h1>
    </header>
    <main>
        <form action="{{ route('register') }}" method="post">
            @csrf
            <h2>会員登録</h2>
            @if ($errors)
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
            @endif
            <div>
                <label for="username">ユーザー名</label>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <label for="password_confirmation">(確認)パスワード</label>
                <input type="password" name="password_confirmation" id="password_confirmation">
            </div>
            <button type="submit">送信する</button>
        </form>
    </main>
    <footer>
        <span>&copy;Tomoyasu Sunagawa 2022.</span>
    </footer>
</body>
</html>