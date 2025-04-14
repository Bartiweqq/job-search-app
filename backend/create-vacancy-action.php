<?php
global $pdo;
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && $_SESSION['role'] === 'employer') {
    $employer_id = $_SESSION['user_id'];
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];

    $stmt = $pdo->prepare("INSERT INTO jobs (employer_id, job_title, job_description, salary, location, date_posted) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$employer_id, $job_title, $job_description, $salary, $location]);

    header("Location: /Kurs/frontend/employer-dashboard.php");
    exit();
} else {
    header("Location: /Kurs/frontend/login.php");
    exit();
}
