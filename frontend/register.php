<?php include 'header.php'; ?>

<div class="container">
    <h2>Регистрация</h2>
    <form action="/Kurs/backend/register-action.php" method="POST">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>

        <select name="role" required>
            <option value="">Выберите роль</option>
            <option value="seeker">Соискатель</option>
            <option value="employer">Работодатель</option>
        </select>

        <button type="submit">Зарегистрироваться</button>
    </form>

    <p><a href="login.php">Уже есть аккаунт? Войти</a></p>
    <p><a href="index.php">На главную</a></p>
</div>

<?php include 'footer.php'; ?>
