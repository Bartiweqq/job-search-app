<?php
$pdo = require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "POST-поступил<br>";
    var_dump($_POST);

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    // Валидация
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        die("❗ Пожалуйста, заполните все поля.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        die("❌ Пользователь с таким email уже существует.");
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute([$username, $email, $hashedPassword, $role]);

    if ($result) {
        echo "✅ Регистрация прошла успешно!";
        // header("Location: /Kurs/frontend/index.php");
        // exit;
    } else {
        echo "❌ Ошибка регистрации: ";
        var_dump($stmt->errorInfo());
    }
}
