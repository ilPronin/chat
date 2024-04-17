<?php
session_start();
require_once __DIR__ . '/../helpers.php';

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
    setOldValue('email', $email);
    setMessageError('error', 'Ошибка валидации');
    redirect('/');
}

$pdo = getPDO();

$stmt = $pdo->prepare("SELECT * FROM users WHERE `email` = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(\PDO::FETCH_ASSOC);

if (!$user){
    setMessageError('error', "Пользователь $email не найден");
    redirect('/');
}

if (!password_verify($password, $user['password'])){
    setMessageError('error', "Неверный пароль");
    redirect('/');
}

$_SESSION['user']['id'] = $user['id'];

redirect('/messenger.php');
