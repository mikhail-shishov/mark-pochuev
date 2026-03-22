<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Доступ запрещен! Только администраторы могут добавлять статьи. <a href='index.php'>На главную</a>");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Добавить статью</title>
</head>
<body class="bg-light">

<?php include 'components/header.php'; ?>

<div class="container pb-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1>Создание новой статьи</h1>
            
            <form action="handlers/add_article.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Заголовок статьи</label>
                    <input type="text" name="title" class="form-control" placeholder="Название статьи" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Основное изображение</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Текст статьи</label>
                    <textarea name="content" id="editor" class="form-control" rows="10" placeholder="Содержание..."></textarea>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Отмена</a>
                    <button type="submit" class="btn btn-primary">Опубликовать</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: 'handlers/upload_article_image.php'
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>

<?php include 'components/footer.php'; ?>

</body>
</html>