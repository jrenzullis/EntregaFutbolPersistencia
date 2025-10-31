<?php
require_once '../persistence/DAO/PartidosDAO.php';
require_once '../persistence/DAO/EquiposDAO.php';
require_once '../templates/header.php';


$partidoDAO = new PartidoDAO();
$equipoDAO = new EquipoDAO();

// Obtener lista de equipos para el formulario
$equipos = $equipoDAO->selectAll();

// Jornada seleccionada (por GET, default 1)
$jornada = isset($_GET['jornada']) ? (int)$_GET['jornada'] : 1;

// Insertar nuevo partido si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_local = $_POST['id_local'];
    $id_visitante = $_POST['id_visitante'];
    $resultado = $_POST['resultado'];
    $estadio = $_POST['estadio'];
    $jornada_post = $_POST['jornada'];

    $inserted = $partidoDAO->insert($id_local, $id_visitante, $resultado, $estadio, $jornada_post);
    if (!$inserted) {
        $error = "Estos equipos ya han jugado entre sí en esta jornada.";
    } else {
        header("Location: partidos.php?jornada=$jornada_post");
        exit;
    }
}

// Obtener todas las jornadas existentes para el combo
$jornadas = $partidoDAO->getJornadas(); // Devuelve array de números de jornada

// Obtener partidos de la jornada seleccionada
$partidos = $partidoDAO->selectByJornada($jornada);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Partidos - Jornada <?= $jornada ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .card-partido { transition: transform 0.2s; }
        .card-partido:hover { transform: scale(1.02); }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4 text-center">Partidos - Jornada <?= $jornada ?></h1>

    <!-- Selección de jornada -->
    <form method="GET" class="mb-4 text-center">
        <label class="form-label me-2">Seleccionar jornada:</label>
        <select name="jornada" class="form-select d-inline-block w-auto">
            <?php foreach ($jornadas as $j): ?>
                <option value="<?= $j ?>" <?= $j == $jornada ? 'selected' : '' ?>><?= $j ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary ms-2">Ver</button>
    </form>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Formulario para agregar partido -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5>Agregar partido</h5>
            <form method="POST" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Equipo local</label>
                    <select name="id_local" class="form-select" required>
                        <option value="">Seleccionar</option>
                        <?php foreach ($equipos as $e): ?>
                            <option value="<?= $e['id_equipo'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Equipo visitante</label>
                    <select name="id_visitante" class="form-select" required>
                        <option value="">Seleccionar</option>
                        <?php foreach ($equipos as $e): ?>
                            <option value="<?= $e['id_equipo'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Resultado</label>
                    <select name="resultado" class="form-select" required>
                        <option value="1">1</option>
                        <option value="X">X</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Estadio</label>
                    <input type="text" name="estadio" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jornada</label>
                    <input type="number" name="jornada" class="form-control" value="<?= $jornada ?>" min="1" required>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success mt-2">Añadir</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de partidos -->
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php if (!empty($partidos)): ?>
            <?php foreach ($partidos as $p): ?>
                <div class="col">
                    <div class="card card-partido shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="mb-2"><?= htmlspecialchars($p['local']) ?> vs <?= htmlspecialchars($p['visitante']) ?></h5>
                            <p class="mb-1">Resultado: <strong><?= htmlspecialchars($p['resultado']) ?></strong></p>
                            <p class="mb-0">Estadio: <?= htmlspecialchars($p['estadio']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col">
                <div class="alert alert-warning text-center">No hay partidos en esta jornada.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

