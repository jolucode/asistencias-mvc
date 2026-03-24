<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=asistenciasdb;charset=utf8mb4', 'root', '');
    $hash = password_hash('password123', PASSWORD_DEFAULT);
    $pdo->exec("UPDATE users SET password = '$hash'");
    echo $hash;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
