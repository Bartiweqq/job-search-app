<?php
include 'db.php';

// Функция для добавления отклика на вакансию
function applyForJob($job_id, $worker_id, $status) {
    global $pdo;
    $sql = "INSERT INTO applications (job_id, worker_id, status) VALUES (:job_id, :worker_id, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':job_id' => $job_id,
        ':worker_id' => $worker_id,
        ':status' => $status
    ]);
    echo "Отклик отправлен!";
}

// Пример добавления отклика
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = $_POST['job_id'];
    $worker_id = $_POST['worker_id']; // Нужно получать ID работника, например, из сессии
    $status = 'В процессе';

    applyForJob($job_id, $worker_id, $status);
}
?>

<form method="POST" action="application_operations.php">
    <input type="number" name="job_id" placeholder="ID вакансии" required>
    <input type="number" name="worker_id" placeholder="ID соискателя" required>
    <button type="submit">Откликнуться</button>
</form>