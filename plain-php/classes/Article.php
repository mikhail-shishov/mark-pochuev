<?php

class Article {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($userId, $title, $content, $image = null) {
        $sql = "INSERT INTO articles (user_id, title, content, image) 
                VALUES (:user_id, :title, :content, :image)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'content' => $content,
            'image' => $image
        ]);
    }

    public function getAll() {
        $sql = "SELECT articles.*, users.name as author_name
                FROM articles
                LEFT JOIN users ON articles.user_id = users.id
                ORDER BY articles.created_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT articles.*, users.name as author_name
                FROM articles
                LEFT JOIN users ON articles.user_id = users.id
                WHERE articles.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function update($id, $title, $content, $image = null) {
        if ($image) {
            $sql = "UPDATE articles SET title = :title, content = :content, image = :image WHERE id = :id";
            $params = [
                'id' => $id,
                'title' => $title,
                'content' => $content,
                'image' => $image
            ];
        } else {
            $sql = "UPDATE articles SET title = :title, content = :content WHERE id = :id";
            $params = [
                'id' => $id,
                'title' => $title,
                'content' => $content
            ];
        }
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id) {
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}