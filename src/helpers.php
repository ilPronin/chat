<?php

session_start();

require_once __DIR__ . '/config.php';
//Функция по редеректу на любую страницу
function redirect(string $path)
{
    header("Location: $path");
    die();
}

function validationErrorMessage($fieldName)
{
    echo $_SESSION['validation'][$fieldName]  ?? "";
}

function hasValidationError(string $fieldName): bool
{
    return isset($_SESSION['validation'][$fieldName]);
}

//function addValidationError(string $fieldName, string $message)
//{
//    $_SESSION['validation'][$fieldName] = $message;
//}

function clearValidation (): void
{
    $_SESSION['validation'] = [];
}

function addOldValue(string $key, mixed $value): void
{
    $_SESSION['old'][$key] = $value;
}

function setOldValue(string $key, mixed $value): void
{
    $_SESSION['old'][$key] = $value;
}
function old(string $key)
{
    $value =  $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}

function uploadFile($file)
{
    $uploadPath = __DIR__ . '/../uploads';

    if(!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = 'file_' . time() . ".$ext";
    $path = "$uploadPath/$fileName";

    if (!move_uploaded_file($file['tmp_name'], $path)) {
        die('Ошибка при загрузке фото на сервер');
    }

    return "uploads/$fileName";
}

function setMessageError(string $key, string$message): void
{
    $_SESSION['message'][$key] = $message;
}

function getMessageError(string $key): string
{
    $message = $_SESSION['message'][$key] ?? '';
    unset($_SESSION['message'][$key]);
    return $message;
}

function hasMessageError(string $key): bool
{
    return isset($_SESSION['message'][$key]);
}

function getPDO(): PDO
{
    try {
        return new \PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME,    DB_USERNAME, DB_PASSWORD);
    } catch (\PDOException $e){
        die("Connection error: {$e->getMessage()}");
    }
}

function getMessages(): false|array
{
    $pdo = getPDO();
    $queryGetMessages = "SELECT users.name, users.email, users.avatar, messages.message, messages.file, messages.date
    FROM users 
    INNER JOIN messages 
    ON users.id=messages.user_id;";

    $qryMessages  = $pdo->prepare($queryGetMessages);
    $qryMessages->execute();
    return $qryMessages->fetchAll(PDO::FETCH_ASSOC);

}

//function getSortMessages(): false|array
//{
//    $pdo = getPDO();
//    $sort_sql = ;
//    $queryGetMessages = "SELECT users.name, users.email, users.avatar, messages.message, messages.file, messages.date
//    FROM users
//    INNER JOIN messages
//    ON users.id=messages.user_id ORDER BY {$sort_sql};";
//
//    $qryMessages  = $pdo->prepare($queryGetMessages);
//    $qryMessages->execute();
//    return $qryMessages->fetchAll(PDO::FETCH_ASSOC);
//}

function logout(): void
{
    unset($_SESSION['user']['id']);
    redirect('/');
}

function checkAuth(): void
{
    if (!isset($_SESSION['user']['id'])){
        redirect('/');
    }
}

//function  getURLQuery()
//{
//    return http_build_query([
//        'page' => $_GET['page'] ?? '',
//        'sort' => $_GET['sort'] ?? ''
//    ]);
//}