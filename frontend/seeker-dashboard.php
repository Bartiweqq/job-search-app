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

// Получаем резюме
$resume_query = "SELECT * FROM resumes WHERE user_id = '$user_id'";
$resume_result = $conn->query($resume_query);

// Получаем отклики
$applications_query = "SELECT * FROM applications WHERE seeker_id = '$user_id'";
$applications_result = $conn->query($applications_query);
?>

<h1>Личный кабинет, <?php echo $username; ?></h1>

<h2>Мое резюме</h2>
<?php
if ($resume_result->num_rows > 0) {
    $resume = $resume_result->fetch_assoc();
    echo "<p>" . $resume['resume_text'] . "</p>";
} else {
    echo "<p>У вас нет резюме. <a href='create-resume.php'>Создать резюме</a></p>";
}
?>

<h2>Мои отклики</h2>
<?php
if ($applications_result->num_rows > 0) {
    while ($application = $applications_result->fetch_assoc()) {
        echo "<p>Вы откликнулись на вакансию: " . $application['vacancy_id'] . " в " . $application['applied_at'] . "</p>";
    }
} else {
    echo "<p>Вы еще не откликались на вакансии.</p>";
}

$conn->close();
include 'footer.php';
?>
