<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit();
}
include 'header.php';
?>

<h2>Создать вакансию</h2>
<form action="/Kurs/backend/create-vacancy-action.php" method="POST">
    <label for="job_title">Название вакансии:</label>
    <input type="text" id="job_title" name="job_title" required><br>

    <label for="job_description">Описание:</label>
    <textarea id="job_description" name="job_description" required></textarea><br>

    <label for="salary">Зарплата:</label>
    <input type="number" id="salary" name="salary" required><br>

    <label for="location">Локация:</label>
    <input type="text" id="location" name="location" required><br>

    <button type="submit">Опубликовать</button>
</form>

<?php include 'footer.php'; ?>
