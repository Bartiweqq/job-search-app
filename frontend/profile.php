<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'header.php';
?>

<h2>Привет, <?php echo $_SESSION['username']; ?>!</h2>
<p>Ваша роль: <?php echo $_SESSION['role']; ?></p>

<a href="logout.php">Выйти</a>

<?php include 'footer.php'; ?>
