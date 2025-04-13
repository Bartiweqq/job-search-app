<?php
global $pdo;
require_once 'db.php';

// Проверка, что форма была отправлена
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Проверка, что все поля заполнены
    if (empty($email) || empty($password)) {
        echo "Пожалуйста, заполните все поля.";
        exit;
    }

    // Подготовка запроса
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Проверка пароля
    if ($user && password_verify($password, $user['password'])) {
        // Успешный вход — временно просто сообщение
        echo "Добро пожаловать, " . htmlspecialchars($user['username']) . "!";
        // Здесь можно будет сделать перенаправление в личный кабинет
    } else {
        echo "Неверный email или пароль.";
    }
} else {
    echo "Неверный метод запроса.";
}
