<?php
//PENDIENTE: Comprobar que recibimos $_POST['texto'] y $_POST['id'] antes de utilizarlos

header('Content-Type: application/json');
require_once ('db.php');

// Limpieza del texto recibido
$texto = trim($_POST['texto']);
$id = $_POST['id'];

// Comprobamos que el texto no está vacío
if ($texto === '') {
    echo json_encode([
        'success' => false,
        'message' => 'ERROR. La idea no puede estar vacía!'
    ]);

    exit();
}

// Búsqueda de una idea con el mismo texto pero diferente ID
$query = $pdo->prepare("SELECT id FROM ideas WHERE texto = :idea AND id != :id;");
$query->execute(['idea' => $texto, 'id' => $id]);

$idea = $query->fetch(PDO::FETCH_ASSOC);

if ($idea !== false){

echo json_encode([
        'success' => false,
        'message' => 'ERROR. La idea ya existe!'
    ]);

    exit();

} else {

    // Intentamos realizar el UPDATE
    try {
        $stmt = $pdo->prepare("UPDATE ideas SET texto = :texto WHERE id=:id;");
        $stmt->execute(['id' => $id, 'texto' => $texto]);

        echo json_encode([
        'success' => true,
        'message' => 'Idea modificada correctamente!'
    ]);

    exit();

    } catch (PDOException $e) {
        error_log($e->getMessage());
            echo json_encode([
        'success' => false,
        'message' => 'ERROR. No se ha podido modificar la idea!'
    ]);

    exit();
    }    
}