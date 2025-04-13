<?php include 'header.php'; ?>

<h1>Список вакансий</h1>
<a href="/frontend/register.php">Зарегистрироваться</a> |
<a href="/frontend/login.php">Войти</a>

<div>
    <h2>Поиск вакансий</h2>
    <form action="/frontend/job-listing.php" method="GET">
        <input type="text" name="search" placeholder="Поиск по вакансии..." required>
        <button type="submit">Искать</button>
    </form>
</div>

<?php include 'footer.php'; ?>
