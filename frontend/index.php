<?php
global $pdo;
session_start();
require_once '../backend/db.php';
include 'header.php';

$stmt = $pdo->query("SELECT * FROM jobs ORDER BY id DESC LIMIT 3");
$latest_jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container fade-in">

    <h1>Добро пожаловать на сайт поиска работы!</h1>

    <?php if (isset($_SESSION['username'])): ?>
        <p class="highlight">Привет, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
    <?php else: ?>
        <div class="auth-links">
            <a href="/Kurs/frontend/register.php" class="button">Зарегистрироваться</a>
            <a href="/Kurs/frontend/login.php" class="button">Войти</a>
        </div>
    <?php endif; ?>

    <p style="margin: 20px 0;">Наш сервис поможет вам быстро найти подходящую вакансию или квалифицированного кандидата.</p>
    <a href="/Kurs/frontend/job-listing.php" class="button">Перейти к вакансиям</a>

    <h3 style="margin-top: 40px;">Последние вакансии</h3>
    <?php if ($latest_jobs): ?>
        <ul class="latest-jobs">
            <?php foreach ($latest_jobs as $job): ?>
                <li>
                    <strong><?= htmlspecialchars($job['job_title']) ?></strong> — <?= htmlspecialchars($job['location']) ?>, <?= htmlspecialchars($job['salary']) ?> ₽
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Вакансий пока нет.</p>
    <?php endif; ?>

    <h3 style="margin-top: 40px;">Что вы можете делать</h3>
    <div class="features-grid">
        <div class="feature-card">
            <h3>👨‍💼 Соискателям</h3>
            <ul>
                <li><a href="/Kurs/frontend/job-listing.php">🔍 Поиск вакансий</a></li>
                <li><a href="/Kurs/frontend/seeker-dashboard.php">📄 Мои отклики</a></li>
                <li><a href="/Kurs/frontend/seeker-dashboard.php#resumeForm">📬 Добавить резюме</a></li>
            </ul>
        </div>
        <div class="feature-card">
            <h3>🏢 Работодателям</h3>
            <ul>
                <li><a href="/Kurs/frontend/employer-dashboard.php#post-job">📢 Публикация вакансий</a></li>
                <li><a href="/Kurs/frontend/employer-dashboard.php#responses">👀 Просмотр откликов</a></li>
                <li><a href="/Kurs/frontend/employer-dashboard.php">📧
