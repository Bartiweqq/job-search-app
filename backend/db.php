<?php
$host = 'localhost';
$dbname = 'jobsearch_db';
$username = 'postgres';
$password = '1234';


try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
return $pdo;

?>
