<?php
session_start();
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Подключение к базе данных
    $conn = new mysqli('localhost', 'username', 'password', 'database'); // Используй свои параметры

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Перенаправление в личный кабинет
            if ($user['role'] == 'seeker') {
                header("Location: seeker-dashboard.php");
            } else {
                header("Location: employer-dashboard.php");
            }
        } else {
            echo "Неверный пароль.";
        }
    } else {
        echo "Пользователь не найден.";
    }

    $conn->close();
}
?>



<h1>Войти</h1>
<form action="/backend/login-action.php" method="POST">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Войти</button>
</form>

<p>Нет аккаунта? <a href="/frontend/register.php">Зарегистрироваться</a></p>
<p><a href="/frontend/index.php">На главную</a></p>




<?php include 'footer.php'; ?>

