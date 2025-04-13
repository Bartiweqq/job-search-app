<?php
$host = 'localhost';
$db = 'jobsearch_db';
$user = 'postgres';
$pass = '1234'; // ← сюда подставь точно тот пароль, который вводил в ALTER ROLE

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    echo "✅ Успешное подключение!";
} catch (PDOException $e) {
    echo "❌ Ошибка: " . $e->getMessage();
}
