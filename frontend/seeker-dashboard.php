<?php
global $pdo;
session_start();
require_once '../backend/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    header("Location: login.php");
    exit();
}

include 'header.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Получаем отклики
$stmt = $pdo->prepare("
    SELECT 
        a.status, a.applied_at,
        j.job_title, j.job_description, j.salary, j.location,
        u.username AS employer_name
    FROM applications a
    JOIN jobs j ON a.job_id = j.id
    JOIN users u ON j.employer_id = u.user_id
    WHERE a.worker_id = ?
    ORDER BY a.applied_at DESC
");
$stmt->execute([$user_id]);
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Добро пожаловать, <?= htmlspecialchars($username) ?></h1>
<h2>Ваши отклики</h2>

<?php if ($applications): ?>
    <?php foreach ($applications as $app): ?>
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px;">
            <h3><?= htmlspecialchars($app['job_title']) ?></h3>
            <p><strong>Описание:</strong> <?= nl2br(htmlspecialchars($app['job_description'])) ?></p>
            <p><strong>Работодатель:</strong> <?= htmlspecialchars($app['employer_name']) ?></p>
            <p><strong>Зарплата:</strong> <?= htmlspecialchars($app['salary']) ?> руб.</p>
            <p><strong>Локация:</strong> <?= htmlspecialchars($app['location']) ?></p>
            <p><strong>Статус:</strong> <?= htmlspecialchars($app['status']) ?></p>
            <p><em>Дата отклика: <?= htmlspecialchars($app['applied_at']) ?></em></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Вы еще не откликались на вакансии.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
