<?php
global $pdo;
include 'db.php'; // Подключаем файл для работы с базой данных
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Соискатель или работодатель

    // Хеширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Проверка на существование пользователя с таким же email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        die("Пользователь с таким email уже существует.");
    }

    // Вставка данных пользователя в таблицу users
    $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $email, $hashedPassword, $role]);

    echo "Регистрация прошла успешно!";
}
?>
