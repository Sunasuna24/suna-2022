<template>
    <div>
        <h1>ここで会員登録するよ</h1>
        <form action="" method="post">
            <label for="name">名前</label>
            <input type="text" name="name" id="name">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email">
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password">
            <label for="password_confirmation">(確認用)パスワード</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
            <button type="submit">送信する</button>
        </form>
    </div>
</template>

<script>
export default {
    //
}
</script>