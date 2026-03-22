<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $uri;

if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    return false;
}

if ($uri === '/' || $uri === '/index.php') {
    include __DIR__ . '/index.php';
} elseif ($uri === '/profile' || $uri === '/profile.php') {
    include __DIR__ . '/profile.php';
} elseif ($uri === '/article' || $uri === '/article.php') {
    include __DIR__ . '/article.php';
} elseif ($uri === '/admin_users' || $uri === '/admin_users.php') {
    include __DIR__ . '/admin_users.php';
} elseif ($uri === '/add_article' || $uri === '/add_article.php') {
    include __DIR__ . '/add_article.php';
} elseif ($uri === '/edit_article' || $uri === '/edit_article.php') {
    include __DIR__ . '/edit_article.php';
} elseif (strpos($uri, '/handlers/') === 0 && file_exists(__DIR__ . $uri)) {
    include __DIR__ . $uri;
} elseif (file_exists(__DIR__ . $uri . '.php')) {
    include __DIR__ . $uri . '.php';
} else {
    include __DIR__ . '/index.php';
}
