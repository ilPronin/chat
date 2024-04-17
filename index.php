<?php
    require_once __DIR__ . '/src/helpers.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="center">
    <form method="post" action="src/actions/login.php">
        <h1>Авторизация</h1>
        <?php if(hasMessageError('error')):?>
            <div class="error"><?php echo getMessageError('error')?></div>
        <?php endif;?>
        <div class="txt_field">
            <label for="email">E-mail</label>
            <input
                type="text"
                id="email"
                name="email"
                placeholder=""
                value="<?= old('email');?>"
                required
            >
            <span"></span>
        </div>

        <div class="password">
            <div class="txt_field">
                <label for="password">Пароль</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder=""
                >
                <span></span>

            </div>
        </div>

        <button
            type="submit"
            id="submit"
        >Войти</button>
        <div class="signup_link">
            <p>У меня еще нет <a href="/register.php">аккаунта</a></p>
        </div>
    </form>
</div>
</body>
</html>