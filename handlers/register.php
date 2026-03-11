<?php
ini_set('display_errors', 1);
require_once '../db/db.php';
require_once '../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userSystem = new User($pdo);

    $success = $userSystem->register(
        $_POST['name'],
        $_POST['lastname'],
        $_POST['email'],
        $_POST['pass']
    );

    if ($success) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Ошибка при регистрации!";
    }
}