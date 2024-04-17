<?php
session_start();
require_once __DIR__ . '/../helpers.php';
require $_SERVER['DOCUMENT_ROOT'] . '/Validator/RegistrationFormValidator.php';

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$avatar = $_FILES['avatar']['error'] == 0 ? $_FILES['avatar'] : null;
$password = htmlspecialchars($_POST['password']);
$passwordConfirmation = htmlspecialchars($_POST['password_confirmation']);
$avatarPath = null;

$validator = New Validator\RegistrationFormValidator($name, $email, $password, $passwordConfirmation, $avatar);

$errors = $validator->setValidationErrors();

$_SESSION['validation'] = $errors;

if (count($errors)){
    addOldValue('name', $name);
    addOldValue('email', $email);
    redirect('/register.php');
}

if ($avatar !== null)
{
    $avatarPath = uploadFile($avatar);
}

$pdo = getPDO();

$query = "INSERT INTO users (name, email, avatar, password) VALUES (:name, :email, :avatar, :password)";
$params = [
    'name' => $name,
    'email' => $email,
    'avatar' => $avatarPath,
    'password' => password_hash($password, PASSWORD_DEFAULT)
];

$stmt = $pdo->prepare($query);

try {
    $stmt->execute($params);
} catch (Exception $e) {
    die($e->getMessage());
}
redirect(('/'));

//Валидация данных
//if (empty($name)){
//    addValidationError('name', 'Введите имя!');
//} elseif (preg_match('/[^A-Za-z0-9]/', $name)){
//    addValidationError('name', 'Можно вводить только латинские символы и цифры!');
//}
//
//if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
//
//    addValidationError('email', 'Указана неверная почта!');
//}
//
//if (empty($password)){
//    addValidationError('password', 'Введите пароль!');
//}
//
//if($password !== $passwordConfirmation){
//    addValidationError('password_confirmation', 'Пароли не совпадают!');
//}
//
////Валидация файла
//    if ($avatar['name'] !== ''){
//        if (!empty($avatar)) {
//            $types = ['image/jpeg', 'image/png'];
//            if (!in_array($avatar['type'], $types)){
//                addValidationError('avatar', 'Изображение профиля имеет неверный тип');
//            } elseif (empty($_SESSION['validation'])){
//                $avatarPath = uploadFile($avatar);
//            }
//        }
//    }
//
//if(!empty($_SESSION['validation'])){
//    addOldValue('name', $name);
//    addOldValue('email', $email);
//
//    redirect('/register.php');
//} else {
//
//    $pdo = getPDO();
//
//    $query = "INSERT INTO users (name, email, avatar, password) VALUES (:name, :email, :avatar, :password)";
//    $params = [
//        'name' => $name,
//        'email' => $email,
//        'avatar' => $avatarPath,
//        'password' => password_hash($password, PASSWORD_DEFAULT)
//    ];
//
//    $stmt = $pdo->prepare($query);
//
//    try {
//        $stmt->execute($params);
//    } catch (\Exception $e) {
//        die($e->getMessage());
//    }
//    redirect(('/'));
//}