<?php
require_once('db.php');

header('Content-Type:application/json');

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
        echo json_encode([
                'success' => false,
                'message' => "Error. Idea vacía!"
            ]);
    // Si la idea ya existe ERROR        
    } elseif ($idea !== false) {
        echo json_encode([
                'success' => false,
                'message' => "Error. Idea duplicada!"
            ]);

    // Sino, ejecutamos lógica INSERT
    } else {

        // Intentamos realizar la inserción con el texto recibido
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO ideas(texto)
                    VALUES (:texto)"
            );

            $stmt->execute(['texto' => $texto]);
            $id = $pdo->lastInsertId();

            echo json_encode([
                'success' => true,
                'message' => "Idea guardada correctamente!",
                'texto' => $texto,
                'id' => $id
            ]);
            
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => "Error. No se ha podido guardar la idea!",
                'texto' => $texto
            ]);
        }
    }
}
// Respuesta JSON y terminación del script
exit();
