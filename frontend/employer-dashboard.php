<?php
global $pdo;
session_start();
require_once '../backend/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: /Kurs/frontend/login.php");
    exit();
}

include 'header.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>

<div class="container fade-in">
    <h1>Личный кабинет работодателя</h1>
    <p>Здравствуйте, <strong><?= htmlspecialchars($username) ?></strong>!</p>

    <hr>

    <h2 onclick="toggleSection('jobForm')">📢 Разместить вакансию</h2>
    <div id="jobForm">
        <form action="/Kurs/backend/post-job.php" method="POST">
            <input type="text" name="job_title" placeholder="Название вакансии" required>
            <input type="number" name="salary" placeholder="Зарплата" required>
            <input type="text" name="location" placeholder="Город" required>
            <textarea name="job_description" placeholder="Описание вакансии" rows="4" required></textarea>
            <button type="submit">Разместить вакансию</button>
        </form>
    </div>

    <hr>

    <h2 onclick="toggleSection('vacancies')">📄 Мои вакансии</h2>
    <div id="vacancies">
        <?php
        $stmt = $pdo->prepare("SELECT * FROM jobs WHERE employer_id = ?");
        $stmt->execute([$user_id]);
        $vacancies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if ($vacancies): ?>
            <?php foreach ($vacancies as $vacancy): ?>
                <div class="card fade-in">
                    <h3><?= htmlspecialchars($vacancy['job_title']) ?></h3>
                    <p><strong>Зарплата:</strong> <?= htmlspecialchars($vacancy['salary']) ?> руб.</p>
                    <p><strong>Локация:</strong> <?= htmlspecialchars($vacancy['location']) ?></p>
                    <p><?= nl2br(htmlspecialchars($vacancy['job_description'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>У вас ещё нет вакансий.</p>
        <?php endif; ?>
    </div>

    <hr>

    <h2 onclick="toggleSection('responses')">📬 Отклики</h2>
    <div id="responses">
        <?php
        $stmt = $pdo->prepare("
            SELECT a.application_date, a.status,
                   u.username AS seeker_name, u.email, u.resume, u.experience,
                   j.job_title
            FROM applications a
            JOIN users u ON a.seeker_id = u.user_id
            JOIN jobs j ON a.vacancy_id = j.id
            WHERE j.employer_id = :employer_id
            ORDER BY a.application_date DESC
        ");
        $stmt->execute(['employer_id' => $user_id]);
        $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if ($applications): ?>
            <?php foreach ($applications as $app): ?>
                <div class="card">
                    <h4>Вакансия: <?= htmlspecialchars($app['job_title']) ?></h4>
                    <p><strong>Соискатель:</strong> <?= htmlspecialchars($app['seeker_name']) ?> (<?= htmlspecialchars($app['email']) ?>)</p>
                    <p><strong>Дата отклика:</strong> <?= htmlspecialchars($app['application_date']) ?></p>
                    <p><strong>Опыт:</strong> <?= nl2br(htmlspecialchars($app['experience'] ?? '—')) ?></p>
                    <p><strong>Резюме:</strong><br><?= nl2br(htmlspecialchars($app['resume'] ?? '—')) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Откликов пока нет.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleSection(id) {
        const section = document.getElementById(id);
        section.style.display = section.style.display === 'none' ? 'block' : 'none';
    }
    </
