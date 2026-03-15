<?php
session_start();
require_once '../db/db.php';
require_once '../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $avatarPath = null;

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/avatars/';
        $tmpName = $_FILES['avatar']['tmp_name'];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($tmpName);
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/avif'
        ];

        if (!in_array($mimeType, $allowedMimeTypes)) {
            header("Location: ../profile.php?error=invalid_type");
            exit();
        }

        $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $fileName = 'avatar_' . $userId . '_' . time() . '.' . $fileExtension;
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            $avatarPath = 'uploads/avatars/' . $fileName;
            
            $userSystem = new User($pdo);
            if ($userSystem->updateAvatar($userId, $avatarPath)) {
                $_SESSION['user_avatar'] = $avatarPath;
                header("Location: ../profile.php?success=1");
                exit();
            } else {
                echo "Ошибка при обновлении аватара в базе данных";
            }
        } else {
            echo "Ошибка при загрузке файла";
        }
    } else {
        header("Location: ../profile.php?error=no_file");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
