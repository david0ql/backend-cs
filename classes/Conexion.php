<?php
class Conexion{
  
  private static $instance = null;
  public $conexion;
  private $username = "root";
  private $password = "Jgomez21!";
  private $dbname = "olansodi";
  private $servername = "localhost";

  public function __construct() {
    $this->conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    $this->conexion->set_charset('utf8');
    date_default_timezone_set("America/Bogota");
  }

  public static function getInstance()
  {
    if (!self::$instance) {
      self::$instance = new Conexion();
    }
    return self::$instance;
  }

  public function getConnection()
  {
    return $this->conexion;
  }
}
?>
