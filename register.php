<?php
//    session_start();
require_once __DIR__ . '/src/helpers.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="center">
        <form method="post" action="src/actions/register.php" enctype="multipart/form-data">
            <h1>Регистрация</h1>
            <div class="txt_field">
                <label for="name">Имя</label>

                <?php  if(hasValidationError('name')):?>
                    <small><?php validationErrorMessage( 'name')?></small>
                <?php endif; ?>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder=""
                    value="<?= old('name'); ?>"
                >
                <span></span>
            </div>


            <div class="txt_field">
                <label for="email">E-mail</label>

                <?php if(hasValidationError('email')): ?>
                    <small><?php validationErrorMessage('email')?></small>
                <?php endif; ?>

                <input
                    type="text"
                    id="email"
                    name="email"
                    placeholder=""
                    value="<?= old('email');?>"

                >
                <span></span>
            </div>

            <div class="file">

                <label class="input-file">
                    <input type="file" id="avatar" name="avatar">
                    <span class="input-file-btn">Выберите фото</span>
                </label>

                <?php if(hasValidationError('avatar')): ?>
                    <small><?php validationErrorMessage('avatar')?></small>
                <?php endif; ?>
            </div>

            <div class="password">
                <div class="txt_field">
                    <label for="password">Пароль</label>

                    <?php if(hasValidationError('password')): ?>
                        <small><?php validationErrorMessage('password')?></small>
                    <?php endif; ?>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder=""
                    >
                    <span></span>
                </div>


                <div class="txt_field">
                    <label for="password">Подтверждение пароля</label>

                    <?php if(hasValidationError('password_confirmation')): ?>
                        <small><?php validationErrorMessage('password_confirmation')?></small>
                    <?php endif; ?>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder=""
                    >
                    <span></span>
                    <small></small>
                </div>
            </div>

            <button
                type="submit"
                id="submit"
            >Зарегистрироваться</button>
            <div class="signup_link">
                <p>У меня уже есть <a href="/">аккаунт</a></p>
            </div>
        </form>
        <?php clearValidation(); ?>
    </div>
</body>
</html>