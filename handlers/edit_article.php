<?php
session_start();
require_once '../db/db.php';
require_once '../classes/Article.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
        die("У вас нет прав для выполнения этого действия!");
    }

    $id = $_POST['id'] ?? null;
    $action = $_POST['action'] ?? 'update';
    
    if (!$id) {
        die("ID статьи не указан!");
    }

    $articleSystem = new Article($pdo);

    if ($action === 'delete') {
        if ($articleSystem->delete($id)) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Ошибка при удалении статьи!";
        }
    } else {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';

        if ($articleSystem->update($id, $title, $content)) {
            header("Location: ../article.php?id=" . $id);
            exit();
        } else {
            echo "Ошибка при обновлении статьи!";
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
