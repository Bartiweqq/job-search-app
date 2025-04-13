<?php include 'header.php';
include 'backend/db.php'; // Подключаем файл для работы с базой данных ?>

<h2>Регистрация</h2>
<form action="/backend/register-action.php" method="POST">
    <label for="username">Имя пользователя:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="email">Электронная почта:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="role">Роль:</label>
    <select id="role" name="role">
        <option value="job_seeker">Соискатель</option>
        <option value="employer">Работодатель</option>
    </select><br>

    <button type="submit">Зарегистрироваться</button>
</form>

<?php include 'footer.php'; ?>
