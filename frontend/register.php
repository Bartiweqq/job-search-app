<?php include 'header.php'; ?>

<h2>Регистрация</h2>
<form action="/Kurs/backend/register-action.php" method="POST">
    <label for="username">Имя пользователя:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="role">Роль:</label>
    <select id="role" name="role" required>
        <option value="seeker">Соискатель</option>
        <option value="employer">Работодатель</option>
    </select><br><br>

    <button type="submit">Зарегистрироваться</button>
</form>

<p><a href="login.php">Уже есть аккаунт? Войти</a></p>
<p><a href="index.php">На главную</a></p>

<?php include 'footer.php'; ?>
