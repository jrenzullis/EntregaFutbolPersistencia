<?php
require_once 'genericDAO.php';

class PartidoDAO extends GenericDAO {

    const TABLE = 'partidos';

    // 🔹 Insertar partido
    public function insert($id_local, $id_visitante, $resultado, $estadio, $jornada) {
        // Validar que los equipos no hayan jugado antes en la misma jornada
        $check = "SELECT id_partido FROM " . self::TABLE . " 
                  WHERE ((id_local=? AND id_visitante=?) OR (id_local=? AND id_visitante=?)) 
                  AND jornada=?";
        $stmt = mysqli_prepare($this->conn, $check);
        mysqli_stmt_bind_param($stmt, 'iiiis', $id_local, $id_visitante, $id_visitante, $id_local, $jornada);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            return false; // Ya jugaron
        }

        $query = "INSERT INTO " . self::TABLE . " (id_local, id_visitante, resultado, estadio, jornada)
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'iissi', $id_local, $id_visitante, $resultado, $estadio, $jornada);
        return mysqli_stmt_execute($stmt);
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

    // 🔹 Obtener todas las jornadas existentes
    public function getJornadas() {
        $query = "SELECT DISTINCT jornada FROM " . self::TABLE . " ORDER BY jornada ASC";
        $result = mysqli_query($this->conn, $query);
        $jornadas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $jornadas[] = $row['jornada'];
        }
        return $jornadas;
    }

    // 🔹 Métodos heredados de GenericDAO (no usados)
    public function selectById($id) { }
    public function update($id, $data) { }
    public function delete($id) { }
}
?>
