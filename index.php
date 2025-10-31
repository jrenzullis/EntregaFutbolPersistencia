<?php
session_start();

// Si el usuario ya visitó los partidos de un equipo
if (isset($_SESSION['ultima_pagina']) && $_SESSION['ultima_pagina'] === 'equipo') {
    $equipo_id = $_SESSION['equipo_id'];
    header("Location: app/partidosEquipo.php?id=$equipo_id");
    exit;
}

// Usuario nuevo o sin sesión → redirigir a equipos.php
header("Location: app/equipos.php");
exit;
