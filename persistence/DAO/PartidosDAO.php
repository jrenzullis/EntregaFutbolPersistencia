<?php
require_once 'genericDAO.php';

class PartidoDAO extends GenericDAO {

    const TABLE = 'partidos';

    // Insertar partido
  public function insert($id_local, $id_visitante, $resultado, $estadio, $jornada) {
  // Validar que no exista ya el mismo partido en cualquier jornada
  $checkQuery = "SELECT * FROM " . self::TABLE . " 
                 WHERE id_local=? AND id_visitante=?";
  $checkStmt = mysqli_prepare($this->conn, $checkQuery);
  mysqli_stmt_bind_param($checkStmt, 'ii', $id_local, $id_visitante);
  mysqli_stmt_execute($checkStmt);
  $checkResult = mysqli_stmt_get_result($checkStmt);

  if (mysqli_num_rows($checkResult) > 0) {
    return [
      'success' => false,
      'message' => 'Estos equipos ya han jugado anteriormente.'
    ];
  }

  $query = "INSERT INTO " . self::TABLE . " 
            (id_local, id_visitante, resultado, estadio, jornada)
            VALUES (?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($this->conn, $query);
  mysqli_stmt_bind_param($stmt, 'iissi', $id_local, $id_visitante, $resultado, $estadio, $jornada);

  if ($stmt->execute()) {
    return [
      'success' => true,
      'message' => 'Partido insertado correctamente.'
    ];
  } else {
    return [
      'success' => false,
      'message' => 'Error al insertar el partido.'
    ];
  }
}


    // 🔹 Obtener partidos por jornada
    public function selectByJornada($jornada) {
        $query = "SELECT p.*, el.nombre AS local, ev.nombre AS visitante
                  FROM " . self::TABLE . " p
                  JOIN equipos el ON p.id_local = el.id_equipo
                  JOIN equipos ev ON p.id_visitante = ev.id_equipo
                  WHERE p.jornada = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $jornada);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $partidos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $partidos[] = $row;
        }
        return $partidos;
    }

    // Obtener todas las jornadas existentes
    public function getJornadas() {
        $query = "SELECT DISTINCT jornada FROM " . self::TABLE . " ORDER BY jornada ASC";
        $result = mysqli_query($this->conn, $query);
        $jornadas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $jornadas[] = $row['jornada'];
        }
        return $jornadas;
    }

    // PartidoDAO.php
    public function selectByEquipo($id_equipo) {
        $query = "SELECT p.*, el.nombre AS local, ev.nombre AS visitante
                  FROM partidos p
                  JOIN equipos el ON p.id_local = el.id_equipo
                JOIN equipos ev ON p.id_visitante = ev.id_equipo
                WHERE p.id_local = ? OR p.id_visitante = ?
                ORDER BY p.jornada ASC";
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
