<?php
global $pdo;
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "Пожалуйста, заполните все поля.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // ✅ Успешный вход: сохраняем в сессию
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // 🎯 Перенаправление на главную
        header("Location: /Kurs/frontend/index.php");
        exit;
    } else {
        echo "Неверный email или пароль.";
    }
} else {
    echo "Неверный метод запроса.";
}
