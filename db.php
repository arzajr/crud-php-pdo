<?php
// Establecer la conexión con la base de datos
$dsn = "mysql:host=localhost;port=3308;dbname=php_prueba";
$user = 'root';
$pass = '';

try {
$pdo = new PDO($dsn, $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión.", $e->getMessage();
}