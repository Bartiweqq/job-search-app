<?php include 'header.php'; ?>

<h2>Вход</h2>
<form action="/Kurs/backend/login-action.php" method="POST">
    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Пароль:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Войти</button>
</form>

<p><a href="register.php">Нет аккаунта? Зарегистрируйтесь</a></p>

<?php include 'footer.php'; ?>
