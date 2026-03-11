<?php
require_once 'db/db.php';
require_once 'classes/Article.php';

session_start();

$articleId = $_GET['id'] ?? null;

if (!$articleId) {
    header("Location: index.php");
    exit();
}

$articleSystem = new Article($pdo);
$article = $articleSystem->getById($articleId);

if (!$article) {
    die("Статья не найдена. <a href='index.php'>На главную</a>");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= htmlspecialchars($article['title']) ?></title>
</head>
<body class="bg-light">

<?php include 'components/header.php'; ?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <article>
                <h1><?= htmlspecialchars($article['title']) ?></h1>
                
                <p class="text-muted">
                    Автор: <?= htmlspecialchars($article['author_name'] ?? 'Неизвестен') ?> | 
                    Дата: <?= date('d.m.Y H:i', strtotime($article['created_at'])) ?>
                </p>

                <div class="content mb-4">
                    <?= nl2br(htmlspecialchars($article['content'])) ?>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Назад</a>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <a href="edit_article.php?id=<?= $article['id'] ?>" class="btn btn-primary">Редактировать</a>
                    <?php endif; ?>
                </div>
            </article>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

</body>
</html>
