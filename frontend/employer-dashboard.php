<?php
session_start();
include 'header.php';

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Подключение к базе данных
$conn = new mysqli('localhost', 'username', 'password', 'database'); // Используй свои параметры

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем вакансии
$vacancies_query = "SELECT * FROM vacancies WHERE employer_id = '$user_id'";
$vacancies_result = $conn->query($vacancies_query);
?>

<h1>Личный кабинет работодателя, <?php echo $username; ?></h1>

<h2>Мои вакансии</h2>
<?php
if ($vacancies_result->num_rows > 0) {
    while ($vacancy = $vacancies_result->fetch_assoc()) {
        echo "<p>" . $vacancy['job_title'] . " - " . $vacancy['description'] . "</p>";
    }
} else {
    echo "<p>У вас нет вакансий. <a href='create-vacancy.php'>Создать вакансию</a></p>";
}

$conn->close();
include 'footer.php';
?>
