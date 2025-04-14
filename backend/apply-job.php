<?php
global $pdo;
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    die("Доступ запрещен");
}

$seeker_id = $_SESSION['user_id'];
$vacancy_id = $_POST['vacancy_id'] ?? null;

if (!$vacancy_id) {
    die("Некорректный запрос.");
}


// Проверяем, не откликался ли уже
$stmt = $pdo->prepare("SELECT * FROM applications WHERE vacancy_id = :vacancy_id AND seeker_id = :seeker_id");
$stmt->execute([
    'vacancy_id' => $vacancy_id,
    'seeker_id' => $seeker_id
]);

if ($stmt->rowCount() > 0) {
    echo "Вы уже откликались на эту вакансию.";
    exit;
}

// Добавляем отклик
$stmt = $pdo->prepare("INSERT INTO applications (vacancy_id, seeker_id, application_date, status) VALUES (:vacancy_id, :seeker_id, NOW(), 'pending')");
$stmt->execute([
    'vacancy_id' => $vacancy_id,
    'seeker_id' => $seeker_id
]);

echo "Отклик отправлен!";
