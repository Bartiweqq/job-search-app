<?php
// Подключение к базе данных
$host = 'localhost';
$dbname = 'job_search';
$user = 'postgres';
$password = 'ТВОЙ_ПАРОЛЬ'; // ЗАМЕНИ на свой пароль

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

// Получение данных из POST-запроса
$email = $_POST['email'] ?? '';
$password_plain = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'jobseeker';

// Хешируем пароль
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

// SQL-запрос
$sql = "INSERT INTO users (email, password, role) VALUES (:email, :password, :role)";

$stmt = $pdo->prepare($sql);
try {
    $stmt->execute([
        ':email' => $email,
        ':password' => $password_hashed,
        ':role' => $role
    ]);
    echo "Регистрация прошла успешно!";
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}