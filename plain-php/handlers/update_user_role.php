<?php
session_start();
require_once '../db/db.php';
require_once '../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
        die("У вас нет прав для выполнения этого действия!");
    }

    $userId = $_POST['user_id'] ?? null;
    $isAdmin = $_POST['is_admin'] ?? 0;

    if (!$userId) {
        die("ID пользователя не указан!");
    }

    if ($userId == $_SESSION['user_id']) {
        die("Вы не можете изменить свои собственные права!");
    }

    $userSystem = new User($pdo);

    if ($userSystem->updateRole($userId, $isAdmin)) {
        header("Location: ../admin_users.php");
        exit();
    } else {
        echo "Ошибка при обновлении прав пользователя!";
    }
} else {
    header("Location: ../index.php");
    exit();
}
