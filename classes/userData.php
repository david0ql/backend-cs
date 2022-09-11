<?php

class userData{

  public static function startSession()
  {
    session_start();
  }

  public static function setSession($username, $id_usuario)
  {
    self::startSession();
    $_SESSION['id_usuario'] = $id_usuario;
    $_SESSION['username'] = $username;
  }

  public static function destroySession()
  {
    self::startSession();
    session_destroy();
    routesRedirect::redirectLogin();
  }

  public static function checkSession()
  {
    self::startSession();
    if (validateData::EmptyData()) routesRedirect::redirectLogin();
  }

  public static function validateIfExist()
  {
    self::startSession();
    if (!validateData::EmptyData()) routesRedirect::redirectDashboard();
  }

  public static function checkLogin( $username, $password )
  {
    $conn = Conexion::getInstance()->getConnection();
    $stmt = $conn->prepare('SELECT * from usuarios WHERE usuario = ? ');
    $stmt->bind_param( 's' , $username );
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
      $user = $result->fetch_assoc();
      if($user['id_permiso'] == 1){
        (password_verify($password, $user["clave"]))
        ?
        (self::setSession($username, $user["id_usuario"])).
        (routesRedirect::redirectDashboard())
        :
        routesRedirect::redirectLogin();
      }else {
        routesRedirect::redirectLogin();
      }
    }else{
      htmlContent::dataIncorrect();
    }

  }

  public static function createNewsletter($id_usuario, $titulo, $contenido, $foto, $url, $id_categoria, $dirigido)
  {
    $conn = Conexion::getInstance()->getConnection();
    $stmt = $conn->prepare('INSERT INTO curso (titulo, contenido, foto, url, id_categoria, dirigido) VALUES (?, ?, ?, ?, ?, ?) ');
    $stmt->bind_param( 'ssssis' , $titulo, $contenido, $foto, $url, $id_categoria, $dirigido );
    $stmt->execute();
  }

  public static function getDocentes()
  {
$dom = "Docente";
    $conn = Conexion::getInstance()->getConnection();
    $stmt = $conn->prepare('select curso.titulo, curso.contenido, curso.foto, curso.url, categorias.nombre, curso.dirigido from curso INNER JOIN categorias ON categorias.id_categoria = curso.id_categoria WHERE curso.dirigido = ? ORDER BY id_curso DESC');
    $stmt->bind_param('s', $dom);
    $stmt->execute();
    $result = $stmt->get_result();
    $arrayData = [];
    while ($row = $result->fetch_assoc()) {
      $revista = new Revista($row);
      array_push($arrayData, $revista);
    }
    return $arrayData;
  }

  public static function getEstudiantes()
  {
$dom = "Docente";
    $conn = Conexion::getInstance()->getConnection();
    $stmt = $conn->prepare("select curso.titulo, curso.contenido, curso.foto, curso.url, categorias.nombre, curso.dirigido from curso INNER JOIN categorias ON categorias.id_categoria = curso.id_categoria WHERE curso.dirigido != ? ORDER BY id_curso DESC");
    $stmt->bind_param('s', $dom);
    $stmt->execute();
    $result = $stmt->get_result();
    $arrayData = [];
    while ($row = $result->fetch_assoc()) {
      $revista = new Revista($row);
      array_push($arrayData, $revista);
    }
    return $arrayData;
  }

}
?>
