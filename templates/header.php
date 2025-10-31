<?php
/**
 * @title: Proyecto integrador Ev01 - Cabecera y barra de navegación
 * @description: Control de sesión y menú dinámico
 * @version: 0.3
 * @authors:
 *   Ander Frago & Miguel Goyena <miguel_goyena@cuatrovientos.org>
 */



// Iniciamos o recuperamos la sesión

?>

<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($user) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="./assets/css/bootstrap.css">
</head>

<body> 
    <!-- Menú para invitado -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="./index.php">Fubol LaLiga</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarMenu" aria-controls="navbarMenu"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="app/signup.php">Equipos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="app/login.php">Partidos</a>
          </li>
        </ul>
      </div>
    </nav>
  <script src="./assets/js/bootstrap.bundle.js"></script>
</body>
