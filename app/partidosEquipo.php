<?php

session_start();



if (isset($_GET['id'])) {
    $_SESSION['ultima_pagina'] = 'equipo';
    $_SESSION['equipo_id'] = (int)$_GET['id'];
}
require_once '../persistence/DAO/PartidosDAO.php';
require_once '../persistence/DAO/EquiposDAO.php';
require_once '../templates/header.php';

// Validar que se haya pasado un id de equipo
if (!isset($_GET['id'])) {
    header('Location: equipos.php');
    exit;
}

$id_equipo = (int)$_GET['id'];

$partidoDAO = new PartidoDAO();
$equipoDAO = new EquipoDAO();

// Obtener información del equipo
$equipo = $equipoDAO->selectById($id_equipo);
if (!$equipo) {
    header('Location: equipos.php');
    exit;
}

// Obtener partidos del equipo
$partidos = $partidoDAO->selectByEquipo($id_equipo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Partidos de <?= htmlspecialchars($equipo['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .card-partido { transition: transform 0.2s; }
        .card-partido:hover { transform: scale(1.02); }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4 text-center">Partidos de <?= htmlspecialchars($equipo['nombre']) ?></h1>

    <div class="mb-4 text-center">
        <a href="equipos.php" class="btn btn-secondary">Volver a Equipos</a>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php if (!empty($partidos)): ?>
            <?php foreach ($partidos as $p): ?>
                <div class="col">
                    <div class="card card-partido shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="mb-2"><?= htmlspecialchars($p['local']) ?> vs <?= htmlspecialchars($p['visitante']) ?></h5>
                            <p class="mb-1">Resultado: <strong><?= htmlspecialchars($p['resultado']) ?></strong></p>
                            <p class="mb-1">Estadio: <?= htmlspecialchars($p['estadio']) ?></p>
                            <p class="mb-0">Jornada: <?= htmlspecialchars($p['jornada']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col">
                <div class="alert alert-warning text-center">No hay partidos registrados para este equipo.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
