<?php
require_once ('db.php');

$stmt= $pdo->prepare("DELETE FROM ideas WHERE id=:id;");

$id = $_POST['id'];

$stmt->execute(['id' => $id]);

header('Location: index.php');
exit();