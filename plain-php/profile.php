<?php
session_start();
require_once 'db/db.php';
require_once 'classes/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$userSystem = new User($pdo);
$userData = $userSystem->getById($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Личный кабинет</title>

    <style>
        .img-thumbnail {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-light">

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h1>Личный кабинет</h1>

                    <?php if ($userData['avatar']): ?>
                        <div class="mb-4">
                                <img src="<?= $userData['avatar'] ?>" alt="Аватар" class="rounded-circle img-thumbnail">
                        </div>
                    <?php endif; ?>

                    <form action="handlers/update_avatar.php" method="POST" enctype="multipart/form-data" class="mb-4">
                        <div class="input-group">
                            <input type="file" name="avatar" class="form-control" accept="image/*" required>
                            <button class="btn btn-primary" type="submit">Сменить фото</button>
                        </div>
                    </form>

                    <p>Добро пожаловать, <b><?= htmlspecialchars($userData['name']) ?></b>!</p>
                    <p>Email: <?= htmlspecialchars($userData['email']) ?></p>
                    
                    <?php if (isset($userData['is_admin']) && $userData['is_admin'] == 1): ?>
                        <p><span class="badge bg-danger">Администратор</span></p>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="index.php" class="btn btn-secondary">На главную</a>
                        <a href="handlers/logout.php" class="btn btn-danger">Выйти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

</body>
</html>