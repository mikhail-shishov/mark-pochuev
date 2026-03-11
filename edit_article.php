<?php
session_start();
require_once 'db/db.php';
require_once 'classes/Article.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

$articleId = $_GET['id'] ?? null;
if (!$articleId) {
    header("Location: index.php");
    exit();
}

$articleSystem = new Article($pdo);
$article = $articleSystem->getById($articleId);

if (!$article) {
    die("Статья не найдена.");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Редактировать статью</title>
</head>
<body class="bg-light">

<?php include 'components/header.php'; ?>

<div class="container pb-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1>Редактирование статьи</h1>
            
            <form action="handlers/edit_article.php" method="POST">
                <input type="hidden" name="id" value="<?= $article['id'] ?>">
                <div class="mb-3">
                    <label class="form-label">Заголовок статьи</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($article['title']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Текст статьи</label>
                    <textarea name="content" class="form-control" rows="10" required><?= htmlspecialchars($article['content']) ?></textarea>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="article.php?id=<?= $article['id'] ?>" class="btn btn-secondary">Отмена</a>
                    <div>
                        <button type="submit" name="action" value="delete" class="btn btn-danger" onclick="return confirm('Удалить статью?')">Удалить</button>
                        <button type="submit" name="action" value="update" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

</body>
</html>
