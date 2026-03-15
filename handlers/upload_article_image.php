<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo json_encode(['error' => ['message' => 'Доступ запрещен']]);
    exit();
}

if (isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/articles/';
    $tmpName = $_FILES['upload']['tmp_name'];

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($tmpName);
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];

    if (!in_array($mimeType, $allowedMimeTypes)) {
        echo json_encode(['error' => ['message' => 'Недопустимый тип файла']]);
        exit();
    }

    $fileExtension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
    $fileName = 'art_img_' . time() . '_' . uniqid() . '.' . $fileExtension;
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($tmpName, $targetFile)) {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json; charset=utf-8');

        $scriptName = $_SERVER['SCRIPT_NAME'];
        $projectRoot = str_replace('handlers/upload_article_image.php', '', $scriptName);
        
        $url = $projectRoot . 'uploads/articles/' . $fileName;
        
        echo json_encode(['url' => $url], JSON_UNESCAPED_SLASHES);
        exit();
    } else {
        echo json_encode(['error' => ['message' => 'Ошибка при перемещении файла']]);
    }
} else {
    echo json_encode(['error' => ['message' => 'Файл не получен или ошибка загрузки']]);
}
