<?php
session_start();
require_once ('db.php');

// Limpieza del texto recibido
$texto = trim($_POST['texto']);
$id = $_POST['id'];

// Comprobamos que el texto no está vacío
if ($texto === '') {
    $_SESSION['mensaje'] = [
        'tipo' => "danger",
        'texto' => "ERROR. La idea no puede estar vacía"
    ];
}

// Búsqueda de una idea con el mismo texto pero diferente ID
$query = $pdo->prepare("SELECT id FROM ideas WHERE texto = :idea AND id != :id;");
$query->execute(['idea' => $texto, 'id' => $id]);

$idea = $query->fetch(PDO::FETCH_ASSOC);

if ($idea !== false){

$_SESSION['mensaje'] = [
    'tipo' => "danger",
    'texto' => "ERROR. La idea ya existe"
];

} else {

    // Intentamos realizar el UPDATE
    try {
        $stmt = $pdo->prepare("UPDATE ideas SET texto = :texto WHERE id=:id;");
        $stmt->execute(['id' => $id, 'texto' => $texto]);

        $_SESSION['mensaje'] = [
            'tipo' => "success",
            'texto' => "Idea modificada correctamente!"
        ];

    } catch (PDOException $e) {
        error_log($e->getMessage());
            $_SESSION['mensaje'] = [
                'tipo' => "danger",
                'texto' => "ERROR: No ha sido posible modificar la idea"
            ];
    }    
}

header('Location: index.php');
exit();