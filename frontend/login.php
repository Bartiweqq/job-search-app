<?php include 'header.php'; ?>

<div class="container">
    <h2>Вход</h2>
    <form class="fade-in" action="/Kurs/backend/login-action.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>

    <p><a href="register.php">Нет аккаунта? Зарегистрируйтесь</a></p>
</div>

<?php include 'footer.php'; ?>
