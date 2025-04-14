<?php
global $pdo;
session_start();
require_once '../backend/db.php';
include 'header.php';

// Получаем последние 3 вакансии
$stmt = $pdo->query("SELECT * FROM jobs ORDER BY id DESC LIMIT 3");
$latest_jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Добро пожаловать на сайт поиска работы!</h1>

<?php if (isset($_SESSION['username'])): ?>
    <p>Привет, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
<?php else: ?>
    <p><a href="/Kurs/frontend/register.php">Зарегистрироваться</a> |
        <a href="/Kurs/frontend/login.php">Войти</a></p>
<?php endif; ?>

<h2>Ищете работу или сотрудников?</h2>
<p>Наш сервис поможет вам быстро найти подходящую вакансию или квалифицированного кандидата.</p>

<a href="/Kurs/frontend/job-listing.php" class="button">Перейти к вакансиям</a>

<hr style="margin: 30px 0;">

<h3>Последние вакансии</h3>
<?php if ($latest_jobs): ?>
    <ul>
        <?php foreach ($latest_jobs as $job): ?>
            <li>
                <strong><?= htmlspecialchars($job['job_title']) ?></strong> —
                <?= htmlspecialchars($job['location']) ?>,
                <?= htmlspecialchars($job['salary']) ?> ₽
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Вакансий пока нет.</p>
<?php endif; ?>

<hr style="margin: 30px 0;">

<div style="display: flex; gap: 30px; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 250px;">
        <h3>Соискателям</h3>
        <ul>
            <li>🔍 Поиск вакансий</li>
            <li>📄 Отклики на вакансии</li>
            <li>📬 Просмотр статуса откликов</li>
        </ul>
    </div>
    <div style="flex: 1; min-width: 250px;">
        <h3>Работодателям</h3>
        <ul>
            <li>📢 Публикация вакансий</li>
            <li>👀 Просмотр откликов</li>
            <li>📧 Связь с кандидатами</li>
        </ul>
    </div>
</div>

<?php include 'footer.php'; ?>
