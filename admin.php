<?php
require_once 'db.php';
require_once 'User.php';
require_once 'Article.php';

$userSystem = new User($pdo);
$articleSystem = new Article($pdo);

$allArticles = $articleSystem->getAll();

foreach ($allArticles as $post) {
    echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
    echo "<p>Автор: " . htmlspecialchars($post['first_name']) . "</p>";
    echo "<div>" . nl2br(htmlspecialchars($post['content'])) . "</div>";
    echo "<hr>";
}