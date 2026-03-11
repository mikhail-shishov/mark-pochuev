<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Личный кабинет</title>
</head>
<body class="bg-light">

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body text-center">
                    <h1>Личный кабинет</h1>
                    <p>Добро пожаловать, <b><?= htmlspecialchars($_SESSION['user_name'] ?? 'Пользователь') ?></b>!</p>
                    <p>Email: <?= htmlspecialchars($_SESSION['user_email']) ?></p>
                    
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
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