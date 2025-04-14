<?php
session_start();
require_once 'db.php';
global $pdo;

if (!isset($_SESSION['user_id'])) {
    die("Нет доступа.");
}

$user_id = $_SESSION['user_id'];
$resume = $_POST['resume'] ?? '';
$experience = $_POST['experience'] ?? '';

$stmt = $pdo->prepare("UPDATE users SET resume = :resume, experience = :experience WHERE user_id = :user_id");
$stmt->execute([
    'resume' => $resume,
    'experience' => $experience,
    'user_id' => $user_id
]);

header("Location: /Kurs/frontend/seeker-dashboard.php");
exit;
