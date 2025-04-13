<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'employer') {
    global $pdo;

    $title = $_POST['title'] ?? '';
    $salary = $_POST['salary'] ?? 0;
    $experience = $_POST['experience'] ?? 0;
    $description = $_POST['description'] ?? '';
    $employer_id = $_SESSION['user_id'];

    // Мини-валидация
    if (!$title || !$description || $salary <= 0) {
        die("Пожалуйста, заполните все поля корректно.");
    }

    $stmt = $pdo->prepare("INSERT INTO jobs (title, description, salary, experience, employer_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $salary, $experience, $employer_id]);

    header("Location: /Kurs/frontend/employer-dashboard.php");
    exit;
}
