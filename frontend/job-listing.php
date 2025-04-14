<?php
global $pdo;
session_start();
require_once '../backend/db.php';
include 'header.php';

// Обработка фильтров
$query = "SELECT jobs.*, users.username AS employer_name
          FROM jobs
          JOIN users ON jobs.employer_id = users.user_id
          WHERE 1=1";
$params = [];

if (!empty($_GET['job_title'])) {
    $query .= " AND jobs.job_title ILIKE ?";
    $params[] = "%" . $_GET['job_title'] . "%";
}
if (!empty($_GET['location'])) {
    $query .= " AND jobs.location ILIKE ?";
    $params[] = "%" . $_GET['location'] . "%";
}
if (!empty($_GET['min_salary'])) {
    $query .= " AND jobs.salary >= ?";
    $params[] = $_GET['min_salary'];
}
if (!empty($_GET['max_salary'])) {
    $query .= " AND jobs.salary <= ?";
    $params[] = $_GET['max_salary'];
}

$query .= " ORDER BY jobs.id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Поиск вакансий</h2>
<form method="GET" action="job-listing.php" style="margin-bottom: 20px;">
    <input type="text" name="job_title" placeholder="Название вакансии" value="<?= htmlspecialchars($_GET['job_title'] ?? '') ?>">
    <input type="text" name="location" placeholder="Город" value="<?= htmlspecialchars($_GET['location'] ?? '') ?>">
    <input type="number" name="min_salary" placeholder="Зарплата от" value="<?= htmlspecialchars($_GET['min_salary'] ?? '') ?>">
    <input type="number" name="max_salary" placeholder="Зарплата до" value="<?= htmlspecialchars($_GET['max_salary'] ?? '') ?>">
    <button type="submit">Найти</button>
</form>

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
                    <input type="hidden" name="vacancy_id" value="<?= $job['id'] ?>">
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
