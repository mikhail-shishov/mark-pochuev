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

        if ($articleSystem->update($id, $title, $content, $imagePath)) {
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
