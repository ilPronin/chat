<?php
require_once __DIR__ . '/../helpers.php';

$sort_list = array(
    'date_asc'   => '`date`',
    'date_desc'  => '`date` DESC',
    'name_asc'   => '`name`',
    'name_desc'  => '`name` DESC',
    'email_asc'  => '`email`',
    'email_desc' => '`email` DESC',

);

$sort = @$_GET['sort'];
if (array_key_exists($sort, $sort_list)) {
    $sort_sql = $sort_list[$sort];
} else {
    $sort_sql = reset($sort_list);
}

$pdo = getPDO();

$querySortMessages = "SELECT users.name, users.email, users.avatar, messages.message, messages.file, messages.date
    FROM users
    INNER JOIN messages
    ON users.id=messages.user_id
    ORDER BY {$sort_sql};";

$qrySortMessages  = $pdo->prepare($querySortMessages);
$qrySortMessages->execute();
$list = $qrySortMessages->fetchAll(PDO::FETCH_ASSOC);
function sort_link_bar($title, $asc, $desc): string
{
    $sort = @$_GET['sort'];

    if ($sort == $asc) {

        return '<a class="active" href="?sort=' . $desc . '">' . $title . ' <i>↑</i></a>';

    } elseif ($sort == $desc) {

        return '<a class="active" href="?sort=' . $asc . '">' . $title . ' <i>↓</i></a>';
    } else {

        return '<a href="?sort=' . $asc . '">' . $title . '</a>';
    }
}