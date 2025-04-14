<?php
global $pdo;
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Kurs/frontend/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = $_POST['id'];
    $title = $_POST['job_title'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $description = $_POST['job_description'];

    $stmt = $pdo->prepare("UPDATE jobs SET job_title = ?, salary = ?, location = ?, job_description = ? WHERE id = ?");
    $stmt->execute([$title, $salary, $location, $description, $job_id]);

    header("Location: /Kurs/frontend/admin-dashboard.php?msg=updated");
    exit();
} else {
    if (!isset($_GET['id'])) {
        die("ID не указан.");
    }

    $job_id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = ?");
    $stmt->execute([$job_id]);
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$job) {
        die("Вакансия не найдена.");
    }

    include 'header.php';
    ?>

    <div class="container">
        <h2>Редактировать вакансию</h2>
        <form method="POST" action="/Kurs/backend/edit-job.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($job['id']) ?>">
            <input type="text" name="job_title" value="<?= htmlspecialchars($job['job_title']) ?>" required>
            <input type="number" name="salary" value="<?= htmlspecialchars($job['salary']) ?>" required>
            <input type="text" name="location" value="<?= htmlspecialchars($job['location']) ?>" required>
            <textarea name="job_description" rows="5" required><?= htmlspecialchars($job['job_description']) ?></textarea>
            <button type="submit">Сохранить изменения</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
<?php } ?>
