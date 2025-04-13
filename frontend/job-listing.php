<?php
global $pdo;
session_start();
include 'header.php';
require_once '../backend/db.php';

// Получаем все вакансии с работодателем
$stmt = $pdo->query("
    SELECT jobs.*, users.username AS employer_name
    FROM jobs
    JOIN users ON jobs.employer_id = users.user_id
    ORDER BY jobs.id DESC
");
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Список вакансий</h2>

<?php if ($jobs): ?>
    <?php foreach ($jobs as $job): ?>
        <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">
            <h3><?= htmlspecialchars($job['job_title']) ?></h3>
            <p><strong>Описание:</strong> <?= nl2br(htmlspecialchars($job['job_description'])) ?></p>
            <p><strong>Зарплата:</strong> <?= htmlspecialchars($job['salary']) ?> руб.</p>
            <p><strong>Локация:</strong> <?= htmlspecialchars($job['location']) ?></p>
            <p><strong>Работодатель:</strong> <?= htmlspecialchars($job['employer_name']) ?></p>
            <p><strong>Дата публикации:</strong> <?= htmlspecialchars($job['date_posted']) ?></p>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'seeker'): ?>
                <form action="/Kurs/backend/apply-job.php" method="POST">
                    <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                    <button type="submit">Откликнуться</button>
                </form>
            <?php elseif (!isset($_SESSION['user_id'])): ?>
                <p><a href="/Kurs/frontend/login.php">Войдите</a>, чтобы откликнуться</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Пока нет опубликованных вакансий.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
