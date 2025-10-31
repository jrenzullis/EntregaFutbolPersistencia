<?php
require 'GenericDAO.php';

class EquipoDAO extends GenericDAO {

  // Nombre real de la tabla
  const TABLE_NAME = 'equipos';

  // Insertar nuevo equipo
  public function insert($nombre, $estadio) {
    $query = "INSERT INTO " . self::TABLE_NAME . " (nombre, estadio) VALUES(?, ?)";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $nombre, $estadio);
    return mysqli_stmt_execute($stmt);
  }

  // Obtener todos los equipos
  public function selectAll() {
    $query = "SELECT * FROM " . self::TABLE_NAME;
    $result = mysqli_query($this->conn, $query);
    $equipos = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $equipos[] = $row;
    }
    return $equipos;
  }

  // Obtener equipo por id
  public function selectById($id) {
    $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE id_equipo=?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
  }

 


}
?>
