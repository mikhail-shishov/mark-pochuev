<?php
require_once 'db/db.php';
require_once 'classes/Article.php';

session_start();

$articleSystem = new Article($pdo);
$articles = $articleSystem->getAll();
$error = $_GET['error'] ?? null;
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Мой Блог - Главная</title>
</head>
<body class="bg-light">

<?php include 'components/header.php'; ?>

<div class="container">
    <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Авторизация</h2>
            <?php if (isset($error) && $error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="handlers/login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="example@mail.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Пароль</label>
                    <input name="pass" type="password" class="form-control" placeholder="******" required>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>

        <div class="col-md-6">
            <h2>Регистрация</h2>
            <form action="handlers/register.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Имя</label>
                    <input name="name" type="text" class="form-control" placeholder="Иван" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Фамилия</label>
                    <input name="lastname" type="text" class="form-control" placeholder="Иванов" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="email@example.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Пароль</label>
                    <input name="pass" type="password" class="form-control" placeholder="Придумайте пароль" required>
                </div>
                <button type="submit" class="btn btn-success">Зарегистрироваться</button>
            </form>
        </div>
    </div>
    <hr>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <h1>Последние публикации</h1>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                    <a href="add_article.php" class="btn btn-primary">➕ Новая статья</a>
                <?php endif; ?>
            </div>

            <?php if (empty($articles)): ?>
                <p>Статей пока нет.</p>
            <?php else: ?>
                <?php foreach ($articles as $post): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="card-title">
                                <a href="article.php?id=<?= $post['id'] ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </h2>
                            <p class="text-muted">
                                Автор: <?= htmlspecialchars($post['author_name'] ?? 'Неизвестен') ?> | 
                                Дата: <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?>
                            </p>
                            <p class="card-text">
                                <?= nl2br(htmlspecialchars(mb_strimwidth($post['content'], 0, 300, "..."))) ?>
                            </p>
                            <a href="article.php?id=<?= $post['id'] ?>">Читать полностью →</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>
</body>
</html>