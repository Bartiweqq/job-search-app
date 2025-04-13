<?php include 'header.php'; ?>

<h1>Регистрация</h1>
<form action="/frontend/register-action.php" method="POST">
    <label for="username">Логин:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="role">Роль:</label>
    <select name="role" id="role" required>
        <option value="job_seeker">Соискатель</option>
        <option value="employer">Работодатель</option>
    </select><br>

    <button type="submit">Зарегистрироваться</button>
</form>

<a href="/frontend/login.php">Уже есть аккаунт? Войти</a>

<?php include 'footer.php'; ?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хэширование пароля
    $role = $_POST['role'];

    // Подключение к базе данных
    $conn = new mysqli('localhost', 'username', 'password', 'database'); // Используй свои параметры

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        echo "Регистрация успешна! <a href='login.php'>Войти</a>";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

include 'footer.php';
?>
