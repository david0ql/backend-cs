<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
//autoload para traer todas las clases
include("../wdywfm/myLoad.php");
//inicializo la sesion
userData::checkSession();
//inicio la sesion
$conn = Conexion::getInstance()->getConnection();
//insertar los datos
$categoria = $_POST['categoria'];
$sql = "insert into categorias (nombre) VALUES ('$categoria')";
$insertar = mysqli_query($conn, $sql);
//redirigir al traer los datos
header("Location: ../ingresarCategorias.php");
?>
