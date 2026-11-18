<?php
session_start();
require_once('db.php');

$ideas = $pdo->query("SELECT * FROM ideas;");
$respuesta = $ideas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ideas</title>

    <!-- JavaScript (fetch) -->
    <script src="script.js" defer></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background-color: #F5F5F2;
            color: #343A36;
        }

        .card {
            border: 1px solid #E2E5E1;
            border-radius: 12px;
        }

        .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background-color: #64756A;
            border-color: #64756A;
        }

        .btn-primary:hover {
            background-color: #536359;
            border-color: #536359;
        }

        .btn-danger {
            background-color: #A47770;
            border-color: #A47770;
        }

        .btn-danger:hover {
            background-color: #8D655F;
            border-color: #8D655F;
        }

        .btn-secondary {
            background-color: #858B85;
            border-color: #858B85;
        }

        .btn-secondary:hover {
            background-color: #707770;
            border-color: #707770;
        }

        .form-control {
            border: 1px solid #E2E5E1;
            border-radius: 8px;
            padding: 10px 12px;
            background-color: #FFFFFF;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            border-color: #64756A;
            box-shadow: 0 0 0 3px rgba(100, 117, 106, 0.15);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            color: #64756A;
            font-weight: 600;
        }

        .table td {
            padding: 12px;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <!-- Título -->
                <h1 class="mb-4">Lista de Ideas </h1>

                <!-- Formulario para añadir ideas -->
                <form id="formulario" action="guardar.php" method="post" class="mb-4">

                    <label class="form-label">Nombre de la Idea</label>

                    <div class="input-group">
                        <input
                            class="form-control"
                            type="text"
                            name="texto"
                            required
                            placeholder="Escribe una idea...">

                        <button class="btn btn-primary" type="submit">
                            Enviar Idea
                        </button>
                    </div>

                </form>


                <?php if (!empty($_SESSION['mensaje'])): ?>

                    <div class="alert alert-<?= $_SESSION['mensaje']['tipo'] ?>" role="alert">
                        <?= htmlspecialchars($_SESSION['mensaje']['texto'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>

                    <?php unset($_SESSION['mensaje']); ?>

                <?php endif; ?>

                <!-- Tabla de ideas -->
                <div class="table-responsive">

                    <table id="tablaIdeas" class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Texto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody id="cuerpoTabla">

                            <?php foreach ($respuesta as $idea): ?>

                                <tr>

                                    <td>
                                        <?= $idea['id'] ?>
                                    </td>

                                    <!-- Formulario para modificar -->
                                    <td>
                                        <form
                                            action="modificar.php"
                                            method="post"
                                            class="d-flex align-items-center gap-2">

                                            <input
                                                class="form-control"
                                                type="text"
                                                name="texto"
                                                value="<?= htmlspecialchars($idea['texto'], ENT_QUOTES, 'UTF-8') ?>"
                                                required>

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $idea['id'] ?>">

                                            <button class="btn btn-secondary" type="submit">
                                                Guardar
                                            </button>

                                        </form>
                                    </td>

                                    <!-- Formulario para eliminar -->
                                    <td>
                                        <form action="eliminar.php" method="post">

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $idea['id'] ?>">

                                            <button class="btn btn-danger" type="submit">
                                                Eliminar
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</body>

</html>