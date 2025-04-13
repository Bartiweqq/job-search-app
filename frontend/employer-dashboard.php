<?php
global $pdo;
session_start();
require_once '../backend/db.php'; // Подключаем PDO

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit();
}

include 'header.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>

<h1>Личный кабинет работодателя, <?php echo htmlspecialchars($username); ?></h1>

<h2>Добавить вакансию</h2>
<form action="/Kurs/backend/post-job.php" method="POST">
    <label>Название вакансии:</label>
    <input type="text" name="title" required><br>

    <label>Зарплата:</label>
    <input type="number" name="salary" required><br>

    <label>Опыт (лет):</label>
    <input type="number" name="experience" required><br>

    <label>Описание:</label><br>
    <textarea name="description" rows="4" cols="50" required></textarea><br>

    <button type="submit">Разместить вакансию</button>
</form>

<hr>

<h2>Мои вакансии</h2>

<?php
$stmt = $pdo->prepare("SELECT * FROM jobs WHERE employer_id = ?");
$stmt->execute([$user_id]);
$vacancies = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($vacancies):
    foreach ($vacancies as $vacancy): ?>
        <div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
            <strong><?= htmlspecialchars($vacancy['title']) ?></strong><br>
            Зарплата: <?= htmlspecialchars($vacancy['salary']) ?> руб.<br>
            Опыт: <?= htmlspecialchars($vacancy['experience']) ?> лет<br>
            <p><?= nl2br(htmlspecialchars($vacancy['description'])) ?></p>
        </div>
    <?php endforeach;
else:
    echo "<p>У вас нет вакансий.</p>";
endif;
?>

<?php include 'footer.php'; ?>
