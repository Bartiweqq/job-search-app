<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search App</title>
    <link rel="stylesheet" href="/Kurs/frontend/style.css">
</head>
<body>
<div class="navbar">
    <div><a href="/Kurs/frontend/index.php">Главная</a></div>
    <div>
        <a href="/Kurs/frontend/job-listing.php">Вакансии</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['role'] === 'employer'): ?>
                <a href="/Kurs/frontend/employer-dashboard.php">Кабинет работодателя</a>
            <?php else: ?>
                <a href="/Kurs/frontend/seeker-dashboard.php">Мой профиль</a>
            <?php endif; ?>
            <a href="/Kurs/backend/logout.php">Выход</a>
        <?php else: ?>
            <a href="/Kurs/frontend/login.php">Войти</a>
            <a href="/Kurs/frontend/register.php">Регистрация</a>
        <?php endif; ?>
    </div>
</div>
