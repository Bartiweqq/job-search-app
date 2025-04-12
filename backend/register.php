<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'user';  // Можно сделать выбор роли через форму

    $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username, ':email' => $email, ':password' => $password, ':role' => $role]);

    echo "Регистрация успешна!";
}
?>

<form method="POST" action="register.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Зарегистрироваться</button>
</form>
