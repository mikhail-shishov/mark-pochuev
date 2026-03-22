<?php

class User {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($name, $lastname, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, lastname, email, password) VALUES (:name, :lastname, :email, :password)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $hashed_password
        ]);
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function getAll() {
        $sql = "SELECT id, name, lastname, email, is_admin FROM users ORDER BY id DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateAvatar($id, $avatar) {
        $sql = "UPDATE users SET avatar = :avatar WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'avatar' => $avatar
        ]);
    }
}