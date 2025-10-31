<?php

$basePath = $_SERVER['DOCUMENT_ROOT'] . '/FutbolEntrega';

require_once $basePath . '/persistence/conf/PersistentManager.php';

abstract class GenericDAO {

  //Conexión a BD
  protected $conn = null;
  //Constructor de la clase
  public function __construct() {
    $this->conn = PersistentManager::getInstance()->get_connection();
  }



}
?>