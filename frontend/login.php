<?php
session_start();
include 'header.php';
?>

<h1>Вход</h1>

<form action="/Kurs/frontend/login-action.php" method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">Войти</button>
</form>

<p>Нет аккаунта? <a href="/Kurs/frontend/register.php">Зарегистрироваться</a></p>
<p><a href="/Kurs/frontend/index.php">На главную</a></p>

<?php include 'footer.php'; ?>
