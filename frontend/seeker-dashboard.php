<?php
global $pdo;
session_start();
require_once '../backend/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    header("Location: /Kurs/frontend/login.php");
    exit();
}

include 'header.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Получаем резюме и опыт пользователя
$stmt = $pdo->prepare("SELECT resume, experience FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

$resume = $userInfo['resume'] ?? '';
$experience = $userInfo['experience'] ?? '';
?>

<div class="container fade-in">

    <h1>Личный кабинет соискателя</h1>
    <p>Здравствуйте, <strong><?= htmlspecialchars($username) ?></strong>!</p>

    <hr>

    <h2 onclick="toggleSection('applications')">📄 Мои отклики</h2>
    <div id="applications" style="display: block;">
        <?php
        $stmt = $pdo->prepare("
            SELECT a.application_date, a.status,
                   j.job_title, j.location, j.salary
            FROM applications a
            JOIN jobs j ON a.vacancy_id = j.id
            WHERE a.seeker_id = ?
            ORDER BY a.application_date DESC
        ");
        $stmt->execute([$user_id]);
        $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if ($applications): ?>
            <?php foreach ($applications as $app): ?>
                <div class="card fade-in">

                    <h3><?= htmlspecialchars($app['job_title']) ?></h3>
                    <p><strong>Локация:</strong> <?= htmlspecialchars($app['location']) ?></p>
                    <p><strong>Зарплата:</strong> <?= htmlspecialchars($app['salary']) ?> руб.</p>
                    <p><strong>Дата отклика:</strong> <?= htmlspecialchars($app['application_date']) ?></p>
                    <p><strong>Статус:</strong> <?= htmlspecialchars($app['status']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Вы пока не откликались на вакансии.</p>
        <?php endif; ?>
    </div>

    <hr>

    <h2 onclick="toggleSection('resumeForm')">📋 Резюме и опыт</h2>
    <div id="resumeForm" style="display: block;">
        <form class="fade-in" action="/Kurs/backend/update-resume.php" method="POST">
            <label for="resume">Резюме:</label>
            <textarea name="resume" rows="5" placeholder="Введите своё резюме..." required><?= htmlspecialchars($resume) ?></textarea>

            <label for="experience">Опыт работы:</label>
            <textarea name="experience" rows="3" placeholder="Опыт работы..." required><?= htmlspecialchars($experience) ?></textarea>

            <button type="submit">Сохранить</button>
        </form>
    </div>
</div>

<script>
    function toggleSection(id) {
        const section = document.getElementById(id);
        section.style.display = section.style.display === 'none' ? 'block' : 'none';
    }
</script>

<?php include 'footer.php'; ?>
