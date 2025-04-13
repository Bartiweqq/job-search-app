<?php include 'header.php'; ?>

<h1>Вход на сайт</h1>
<form action="login-action.php" method="POST">
    <label for="username">Имя пользователя:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Войти</button>
</form>

<?php include 'footer.php'; ?>
