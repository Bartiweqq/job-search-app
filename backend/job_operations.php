
<?php
include 'db.php';

// Функция для добавления вакансии
function addJob($title, $description, $salary, $employer_id) {
    global $pdo;
    $sql = "INSERT INTO jobs (title, description, salary, employer_id) VALUES (:title, :description, :salary, :employer_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':salary' => $salary,
        ':employer_id' => $employer_id
    ]);
    echo "Вакансия успешно добавлена!";
}

// Пример добавления вакансии
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];
    $employer_id = $_POST['employer_id']; // Нужно получать ID работодателя, например, из сессии

    addJob($title, $description, $salary, $employer_id);
}
?>

<form method="POST" action="job_operations.php">
    <input type="text" name="title" placeholder="Название вакансии" required>
    <textarea name="description" placeholder="Описание вакансии" required></textarea>
    <input type="number" name="salary" placeholder="Зарплата" required>
    <input type="number" name="employer_id" placeholder="ID работодателя" required>
    <button type="submit">Добавить вакансию</button>
</form>
