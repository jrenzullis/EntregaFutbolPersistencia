<?php
require 'GenericDAO.php';

class PartidoDAO extends GenericDAO {

  const TABLE_NAME = 'partidos';

  // 🔹 Insertar un nuevo partido
  public function insert($id_local, $id_visitante, $resultado, $estadio) {
    // Validación: que los equipos no hayan jugado previamente
    $queryCheck = "SELECT COUNT(*) as count FROM " . self::TABLE_NAME . " 
                   WHERE (id_local=? AND id_visitante=?) OR (id_local=? AND id_visitante=?)";
    $stmtCheck = mysqli_prepare($this->conn, $queryCheck);
    mysqli_stmt_bind_param($stmtCheck, 'iiii', $id_local, $id_visitante, $id_visitante, $id_local);
    mysqli_stmt_execute($stmtCheck);
    $resultCheck = mysqli_stmt_get_result($stmtCheck);
    $row = mysqli_fetch_assoc($resultCheck);

    if ($row['count'] > 0) {
        return false; // ya jugaron antes
    }

    // Insertar el partido
    $query = "INSERT INTO " . self::TABLE_NAME . " (id_local, id_visitante, resultado, estadio) VALUES(?, ?, ?, ?)";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'iiss', $id_local, $id_visitante, $resultado, $estadio);
    return mysqli_stmt_execute($stmt);
  }

  // 🔹 Obtener todos los partidos (con nombres de equipos)
  public function selectAll() {
    $query = "SELECT p.id_partido, el.nombre AS local, ev.nombre AS visitante, p.resultado, p.estadio
              FROM partidos p
              JOIN equipos el ON p.id_local = el.id_equipo
              JOIN equipos ev ON p.id_visitante = ev.id_equipo";
    $result = mysqli_query($this->conn, $query);
    $partidos = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $partidos[] = $row;
    }
    return $partidos;
  }

  // 🔹 Obtener partidos de un equipo concreto
  public function selectByEquipo($id_equipo) {
    $query = "SELECT p.id_partido, el.nombre AS local, ev.nombre AS visitante, p.resultado, p.estadio
              FROM partidos p
              JOIN equipos el ON p.id_local = el.id_equipo
              JOIN equipos ev ON p.id_visitante = ev.id_equipo
              WHERE p.id_local=? OR p.id_visitante=?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $id_equipo, $id_equipo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $partidos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $partidos[] = $row;
    }
    return $partidos;
  }

}
?>
