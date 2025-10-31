<?php



$basePath = $_SERVER['DOCUMENT_ROOT'] . '/FutbolEntrega';

require_once $basePath . '/persistence/DAO/EquiposDAO.php';
require_once $basePath . '/templates/header.php';


// Crear instancia del DAO
$dao = new EquipoDAO();

// Insertar nuevo equipo si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $estadio = $_POST['estadio'] ?? '';

    if (!empty($nombre) && !empty($estadio)) {
        $dao->insert($nombre, $estadio);
        header("Location: equipos.php");
        exit;
    }
}

$equipos = $dao->selectAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Equipos - Artean</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">

    <h1 class="mb-4 text-center">Equipos</h1>

    <!-- Tarjeta de agregar nuevo equipo -->
    <div class="row mb-4">
        <div class="col-md-4 offset-md-4">
            <div class="card add-team-card p-3 shadow" data-bs-toggle="collapse" data-bs-target="#addTeamForm">
                <div class="text-center">➕ Agregar nuevo equipo</div>
            </div>
            <div class="collapse mt-3" id="addTeamForm">
                <div class="card p-3 shadow-sm">
                    <form method="POST" class="row g-2">
                        <div class="col-12">
                            <input type="text" name="nombre" class="form-control" placeholder="Nombre del equipo" required>
                        </div>
                        <div class="col-12">
                            <input type="text" name="estadio" class="form-control" placeholder="Estadio" required>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success w-100">Guardar equipo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de equipos -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($equipos)): ?>
            <?php foreach ($equipos as $e): ?>
                <div class="col">
                    <div class="card team-card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="team-name"><?= htmlspecialchars($e['nombre']) ?></h5>
                            <p class="team-stadium"><?= htmlspecialchars($e['estadio']) ?></p>
                            <a href="partidosEquipo.php?id=<?= $e['id_equipo'] ?>" class="btn btn-primary mt-2">Ver partidos</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col">
                <div class="alert alert-warning text-center">No hay equipos registrados.</div>
            </div>
        <?php endif; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>