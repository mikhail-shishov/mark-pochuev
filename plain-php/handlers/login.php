<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once '../db/db.php';
require_once '../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['pass'] ?? '';

    $userSystem = new User($pdo);
    $userData = $userSystem->login($email, $password);

    if ($userData) {
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['user_name'] = $userData['name'];
        $_SESSION['is_admin'] = $userData['is_admin'] ?? 0;

        header("Location: ../profile.php");
        exit();
    } else {
        die("Ошибка: Неверный email или пароль. <a href='../index.php'>Назад</a>");
    }
} else {
    header("Location: ../index.php");
    exit();
}