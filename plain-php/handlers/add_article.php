<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../db/db.php';
require_once '../classes/Article.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
        die("У вас нет прав для публикации статей!");
    }

    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $userId = $_SESSION['user_id'];
    $imagePath = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/articles/';
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExtension;
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = 'uploads/articles/' . $fileName;
        }
    }

    $articleSystem = new Article($pdo);

    if ($articleSystem->create($userId, $title, $content, $imagePath)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Ошибка при сохранении статьи!";
    }
} else {
    echo "Доступ запрещен!";
}
