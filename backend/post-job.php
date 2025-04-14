<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'employer') {
    global $pdo;

    $title = $_POST['job_title'] ?? '';
    $description = $_POST['job_description'] ?? '';
    $salary = $_POST['salary'] ?? 0;
    $location = $_POST['location'] ?? '';
    $employer_id = $_SESSION['user_id'];

    if (!$title || !$description || $salary <= 0 || !$location) {
        die("Пожалуйста, заполните все поля корректно.");
    }

    $stmt = $pdo->prepare("INSERT INTO jobs (job_title, job_description, salary, location, employer_id, date_posted)
                           VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$title, $description, $salary, $location, $employer_id]);

    header("Location: /Kurs/frontend/employer-dashboard.php");
    exit;
}
