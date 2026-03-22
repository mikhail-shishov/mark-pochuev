<?php
session_start();
require_once 'db/db.php';
require_once 'classes/User.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

$userSystem = new User($pdo);
$users = $userSystem->getAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Управление пользователями</title>
</head>
<body class="bg-light">

<?php include 'components/header.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h1>Управление пользователями</h1>
            
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя Фамилия</th>
                        <th>Email</th>
                        <th>Статус</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['name'] . ' ' . $u['lastname']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <?= $u['is_admin'] == 1 ? 'Админ' : 'Юзер' ?>
                        </td>
                        <td>
                            <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                <form action="handlers/update_user_role.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                    <input type="hidden" name="is_admin" value="<?= $u['is_admin'] == 1 ? 0 : 1 ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-dark">
                                        <?= $u['is_admin'] == 1 ? 'Снять админа' : 'Сделать админом' ?>
                                    </button>
                                </form>
                            <?php else: ?>
                                <small>Это вы</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

</body>
</html>
