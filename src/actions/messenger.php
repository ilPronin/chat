<?php

require_once __DIR__ . '/../helpers.php';

//var_dump($_POST);
//var_dump($_FILES);

$message = htmlspecialchars($_POST['message']);
$file = $_FILES['file'] ?? null;
$date = date("Y-m-d H:i:s");
$userId = $_SESSION['user']['id'];
$filePath = null;


if ($file['name'] === ''){
    var_dump($file);
}
//print_r("$message, $date, $userId");

if ($file['name'] !== ''){
    if (!empty($file)) {
        $typesOfImg = ['image/jpeg', 'image/png', 'image/gif'];
        $typesOfDoc = ['text/plain'];

        if (in_array($file['type'], $typesOfImg)) {
            $image_info = getimagesize($file["tmp_name"]);
            $image_width = $image_info[0];
            $image_height = $image_info[1];
            if ($image_height > 320 || $image_width > 240){
                setMessageError('error', "Размер картинки слишком большой");
                redirect('/messenger.php');
            } else {
                $filePath = uploadFile($file);
            }
        } elseif (in_array($file['type'], $typesOfDoc) && $file['size'] < 80000){
            $filePath = uploadFile($file);
        } else{
            setMessageError('error', "Файл имеет неверный формат, либо слишком большой");
//        redirect('/messenger.php');
        }
    }
}

$pdo = getPDO();

$query = "INSERT INTO messages (message, file, date, user_id) VALUES (:message, :file, :date, :user_id)";

$params = [
    'message' => $message,
    'file' => $filePath,
    'date' => $date,
    'user_id' => $userId
];

$stmt = $pdo->prepare($query);

try {
    $stmt->execute($params);
} catch (\Exception $e) {
    die($e->getMessage());
}



redirect('/messenger.php');