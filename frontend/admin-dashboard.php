<?php
global $pdo;
session_start();
require_once '../backend/db.php';
include 'header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Kurs/frontend/login.php");
    exit();
}
?>

<div class="container">
    <h1>Панель администратора</h1>

    <h2>Пользователи</h2>
    <?php
    $stmt = $pdo->query("SELECT user_id, username, email, role FROM users ORDER BY user_id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Имя</th><th>Email</th><th>Роль</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['user_id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <hr>

    <h2>Вакансии</h2>
    <?php
    $stmt = $pdo->query("
        SELECT jobs.id, jobs.job_title, jobs.salary, jobs.location, users.username AS employer 
        FROM jobs
        JOIN users ON jobs.employer_id = users.user_id
        ORDER BY jobs.id DESC
    ");
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php if ($jobs): ?>
        <?php foreach ($jobs as $job): ?>
            <div class="card">
                <h3><?= htmlspecialchars($job['job_title']) ?> — <?= htmlspecialchars($job['location']) ?></h3>
                <p><strong>Зарплата:</strong> <?= $job['salary'] ?> ₽</p>
                <p><strong>Работодатель:</strong> <?= htmlspecialchars($job['employer']) ?></p>
                <form action="/Kurs/backend/delete-job.php" method="POST" style="display:inline;">
                    <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                    <button type="submit" onclick="return confirm('Удалить вакансию?')">❌ Удалить</button>
                </form>
                <a href="/Kurs/frontend/edit-job.php?id=<?= $job['id'] ?>" class="button">✏️ Редактировать</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Нет вакансий.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
