<?php
global $pdo;
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Kurs/frontend/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Не указана вакансия для удаления.");
}

$job_id = intval($_GET['id']);

$stmt = $pdo->prepare("DELETE FROM jobs WHERE id = ?");
$stmt->execute([$job_id]);

header("Location: /Kurs/frontend/admin-dashboard.php?msg=deleted");
exit();
?>
