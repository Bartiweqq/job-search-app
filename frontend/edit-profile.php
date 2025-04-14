<?php
global $pdo;
session_start();
require_once '../backend/db.php';
include 'header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    header("Location: /Kurs/frontend/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT resume, experience FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<h2>Редактировать профиль</h2>
<form action="/Kurs/backend/update-profile.php" method="POST">
    <label>Резюме:</label><br>
    <textarea name="resume" rows="5" cols="50"><?= htmlspecialchars($user['resume']) ?></textarea><br><br>

    <label>Опыт работы:</label><br>
    <textarea name="experience" rows="5" cols="50"><?= htmlspecialchars($user['experience']) ?></textarea><br><br>

    <button type="submit">Сохранить</button>
</form>

<p><a href="/Kurs/frontend/seeker-dashboard.php">Назад в кабинет</a></p>

<?php include 'footer.php'; ?>
