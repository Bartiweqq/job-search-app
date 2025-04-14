<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    header("Location: /Kurs/frontend/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    global $pdo;

    $resume = $_POST['resume'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("UPDATE users SET resume = :resume, experience = :experience WHERE user_id = :user_id");
    $stmt->execute([
        'resume' => $resume,
        'experience' => $experience,
        'user_id' => $user_id
    ]);

    // Редирект обратно в кабинет
    header("Location: /Kurs/frontend/seeker-dashboard.php");
    exit();
}
?>