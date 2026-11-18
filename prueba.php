<?php
require_once 'db.php';

// PEPARAR UNA CONSULTA

$stmt = $pdo->prepare("INSERT INTO ideas(texto) VALUES(:texto)");
$texto = "Aprender PDO";
$stmt->execute(['texto' => $texto]);

//  DEVOLVER TODAS LAS TAREAS
$ideas = $pdo->query("SELECT * FROM ideas;");
$respuesta = $ideas->fetchAll(PDO::FETCH_ASSOC);

var_dump($respuesta);
