<?php
global $pdo;
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && $_SESSION['role'] === 'seeker') {
    $job_id = $_POST['job_id'];
    $worker_id = $_SESSION['user_id'];

    // Проверка, откликался ли уже
    $stmt = $pdo->prepare("SELECT * FROM applications WHERE job_id = ? AND worker_id = ?");
    $stmt->execute([$job_id, $worker_id]);

    if ($stmt->rowCount() > 0) {
        header("Location: /Kurs/frontend/seeker-dashboard.php?error=already_applied");
        exit;
    }

    // Добавляем отклик
    $stmt = $pdo->prepare("INSERT INTO applications (job_id, worker_id, status, applied_at) VALUES (?, ?, 'отправлено', NOW())");
    $stmt->execute([$job_id, $worker_id]);

    header("Location: /Kurs/frontend/seeker-dashboard.php?success=1");
    exit;
} else {
    header("Location: /Kurs/frontend/login.php");
    exit;
}
