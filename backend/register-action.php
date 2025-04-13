<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $pdo;

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    // Валидация
    if (!$username || !$email || !$password || !$role) {
        die("Пожалуйста, заполните все поля.");
    }

    // Проверка на уникальность email и username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
    $stmt->execute(['email' => $email, 'username' => $username]);
    if ($stmt->rowCount() > 0) {
        die("Пользователь с таким email или именем уже существует.");
    }

    // Хеширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Добавление в БД
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
    $success = $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword,
        'role' => $role
    ]);

    if ($success) {
        header("Location: /Kurs/frontend/login.php");
        exit;
    } else {
        echo "Ошибка регистрации.";
    }
}
