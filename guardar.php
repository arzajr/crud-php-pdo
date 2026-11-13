<?php
session_start();
require_once('db.php');

// Si la petición es POST y la variable texto contiene información
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['texto'])) {

    // Limpieza de texto
    $texto = trim($_POST['texto']);

    // Obtención del id de la idea con el texto recibido
    $query = $pdo->prepare("SELECT id FROM ideas WHERE texto = :idea;");
    $query->execute(['idea' => $texto]);

    $idea = $query->fetch(PDO::FETCH_ASSOC);

    // Si el texto está vacío ERROR
    if ($texto === '') {
        $_SESSION['mensaje'] = [
            'tipo' => "danger",
            'texto' => "ERROR: Idea vacía"
        ];

    // Si la idea ya existe ERROR        
    } elseif ($idea !== false) {
        $_SESSION['mensaje'] = [
            'tipo' => "danger",
            'texto' => "ERROR: Idea duplicada"
        ];

    // Sino, ejecutamos lógica INSERT
    } else {

        // Intentamos realizar la inserción con el texto recibido
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO ideas(texto)
                    VALUES (:texto)"
            );

            $stmt->execute(['texto' => $texto]);

            $_SESSION['mensaje'] = [
                'tipo' => "success",
                'texto' => "Idea guardada correctamente!"
            ];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $_SESSION['mensaje'] = [
                'tipo' => "danger",
                'texto' => "ERROR: No ha sido posible guardar la idea"
            ];
        }
    }
}
// Redirección y terminación del script
header('Location: index.php');
exit();
