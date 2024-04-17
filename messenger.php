<?php
    session_start();
    require_once __DIR__ . '/src/helpers.php';
    require_once __DIR__ . '/src/actions/sort.php';
    checkAuth();

    $page = $_GET['page'] ?? 0;
    $messages = $list;
    $countOfMessages = 4;
    $countOfPages = floor(count($messages) / $countOfMessages );
    $currentSort = $_GET['sort'] ?? null;
    $currentPage = $_GET['page'] ?? 0;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>ЧАТ</title>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <header>
                <h1>ЧАТ</h1>
                <form action="src/actions/logout.php" method="post" class="logout">
                    <button class="logout-btn">Выйти</button>
                </form>
            </header>
            <main>
                <div class="sort-bar">
                    <div class="sort-bar-title">
                        <p>Сортировать по:</p>
                    </div>
                    <div class="sort-bar-list">
                        <?php echo sort_link_bar('Имя', 'name_asc', 'name_desc'); ?>
                        <?php echo sort_link_bar('E-mail', 'email_asc', 'email_desc'); ?>
                        <?php echo sort_link_bar('Дата', 'date_asc', 'date_desc'); ?>
                    </div>

                </div>
                <table>

                    </thead>
                    <tbody>
                        <?php

                            if (getMessages()):
                                for ($i = $page*$countOfMessages; $i < ($page+1)*$countOfMessages; $i++):
                                    if (array_key_exists($i, $messages)): ?>
                                        <tr>
                                            <td><img src="<?= ($messages[$i]['avatar'] === null) ? "uploads/avatar.jpg" :  $messages[$i]['avatar']?>" class="user-avatar" alt=""></td>
                                            <td>
                                                <div class="user-info">
                                                    <p class="user-name"><?= $messages[$i]['name']?></p>
                                                    <p class="user-email"><?= $messages[$i]['email']?></p>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="user-message"><?= $messages[$i]['message']?></p>
                                                <?php
                                                    if ($messages[$i]['file'] !== null):
                                                        if (str_ends_with($messages[$i]['file'], 'txt')): ?>
                                                            <a href="<?= $messages[$i]['file']?>" download><?= $messages[$i]['file']?></a>
                                                        <?php  else: ?>
                                                            <img src="<?= $messages[$i]['file']?>" alt="">
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <p class="date"><?= $messages[$i]['date']?></p>
                                            </td>
                                        </tr>
                                    <?php endif;
                                endfor;?>
                            <?php else: ?>
                                <h2>Сообщений нет</h2>
                            <?php endif;?>
                    </tbody>
                </table>
                <div class="page-list" align="center">
                    <?php for ($p = 0; $p <= $countOfPages; $p++): ?>
<!--                        <a href="/messenger.php?page=--><?php //=$p?><!--"><button class="page_button">--><?php //= $p + 1;?><!--</button></a>-->
                        <a href="/messenger.php?<?=
                            isset($_GET['sort']) ? 'sort=' . $_GET['sort'] . '&page=' . $p :  'page=' . $p;
                        ?>"><button class="page_button"><?= $p + 1;?></button></a>
                    <?php endfor;?>
                </div>
            </main>
            <footer>
                <form method="post" action="src/actions/messenger.php" enctype="multipart/form-data">
                    <div class="send-message">
                        <?php if(hasMessageError('error')):?>
                            <div class="error"><?php echo getMessageError('error')?></div>
                        <?php endif;?>
                        <div class="message_input">
                            <label for="message"></label>
                            <input
                                    type="text"
                                    id="message"
                                    name="message"
                                    placeholder="Введите сообщение"
                                    value=""
                                    required
                            >
                            <span></span>
                        </div>
                        <div class="file">
                            <label class="input-file">
                                <input type="file" id="file" name="file">
                                <span class="input-file-paperclip"><img src="/img/paperclip.png" class="paperclip" alt=""></span>
                            </label>
                            <?php if(hasValidationError('file')): ?>
                                <small><?php validationErrorMessage('file')?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button
                            type="submit"
                            id="submit"
                    >Отправить</button>
                </form>
            </footer>
<!--            <pre>-->
<!--                --><?php //= $_GET['sort']?>
<!--                --><?php //= $_GET['page']?>
<!--                --><?php //='1)' . $sort?>
<!--                --><?php //= $currentPage?>
<!--            </pre>-->
        </div>
    </div>
</body>
</html>