<?php
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/FutbolEntrega';

require_once $basePath . '/persistence/DAO/EquiposDAO.php';

// Crear instancia del DAO
$dao = new EquipoDAO();

// 🔹 Insertar nuevo equipo si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $estadio = $_POST['estadio'] ?? '';

    if (!empty($nombre) && !empty($estadio)) {
        $dao->insert($nombre, $estadio);
        header("Location: equipos.php");
        exit;
    }
}

// 🔹 Obtener todos los equipos
$equipos = $dao->selectAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Equipos - Artean</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4">Equipos</h1>

    <!-- Formulario para agregar equipo -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="POST" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="nombre" class="form-label">Nombre del equipo</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Athletic Club" required>
                </div>
                <div class="col-md-5">
                    <label for="estadio" class="form-label">Estadio</label>
                    <input type="text" name="estadio" id="estadio" class="form-control" placeholder="Ej: San Mamés" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Agregar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de equipos -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Estadio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipos as $e): ?>
                        <tr>
                            <td><?= $e['id_equipo'] ?></td>
                            <td>
                                <a href="partidosEquipo.php?id=<?= $e['id_equipo'] ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($e['nombre']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($e['estadio']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($equipos)): ?>
                        <tr>
                            <td colspan="3" class="text-center">No hay equipos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
